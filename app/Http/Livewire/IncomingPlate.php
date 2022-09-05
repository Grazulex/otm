<?php

namespace App\Http\Livewire;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Models\Incoming;
use App\Models\Plate;
use Closure;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IncomingPlate extends Component  implements Tables\Contracts\HasTable
{


    //plate = plate.slice(0,9).replace(/[^\w\s]|_/g, "").replace(/\n/g, " ").replace(/\s+/g, " ");
    //cod = (cod.slice(0,-4).slice(4))/100;


    use Tables\Concerns\InteractsWithTable;

    public Incoming $incoming;

    public $plates;
    public string $datamatrix;
    public string $cod;
    public string $type;
    public bool $cod_is_disable;

    protected int | string | array $columnSpan = 'full';

    public function mount()
    {
        $this->datamatrix = '';
        $this->cod = '';
        $this->type = 'cod';
        $this->cod_is_disable = true;
    }

    public function searchDatamatrix()
    {
        $datamatrix = preg_replace('/[^a-z0-9]+/i', '', substr(trim($this->datamatrix), 0, 9));
        if ($this->type == 'cod') {
            $plate = Plate::where('reference', $datamatrix)
                ->whereNull('incoming_id')
                ->whereIn('type', TypeEnums::cases())
                ->where('is_cod', true)
                ->where('is_rush', false)
                ->first();
        } elseif ($this->type == 'rush') {
            $plate = Plate::where('reference', $datamatrix)
                ->whereNull('incoming_id')
                ->whereIn('type', TypeEnums::cases())
                ->where('is_cod', false)
                ->where('is_rush', true)
                ->first();
        } else {
            $plate = Plate::where('reference', $datamatrix)
                ->whereNull('incoming_id')
                ->whereIn('type', TypeEnums::cases())
                ->where('is_cod', false)
                ->where('is_rush', false)
                ->first();
        }
        if ($plate) {
            $plate->incoming_id = $this->incoming->id;
            $plate->save();
            Notification::make()
                ->title('Plate finded and saved successfully')
                ->success()
                ->seconds(2)
                ->send();
        } else {
            if ($this->type == 'cod' || $this->type == 'rush') {
                $this->cod_is_disable = false;
                $this->emit('focusCod');
            }
            if ($this->type != 'cod' && $this->type != 'rush') {
                $plate = Plate::create([
                    'reference' => $datamatrix,
                    'is_cod' => false,
                    'is_rush' => false,
                    'type' => TypeEnums::N1FS->value,
                    'incoming_id' => $this->incoming->id,
                    'customer' => '',
                    'origin' => OriginEnums::OTHER->value,
                ]);
                Notification::make()
                    ->title('Plate created and saved successfully')
                    ->warning()
                    ->seconds(2)
                    ->send();
                $this->datamatrix = '';
            }
        }
    }

    public function searchCod()
    {
        $datamatrix = preg_replace('/[^a-z0-9]+/i', '', substr(trim($this->datamatrix), 0, 9));
        $cod = (int)substr(trim($this->cod), 4, 6) / 100;
        if ($this->type == 'cod') {
            $plate = Plate::create([
                'reference' => $datamatrix,
                'is_cod' => true,
                'is_rush' => false,
                'amount' => (int)$cod,
                'type' => TypeEnums::N1FS->value,
                'incoming_id' => $this->incoming->id,
                'customer' => '',
                'origin' => OriginEnums::OTHER->value,
            ]);
        } else {
            $plate = Plate::create([
                'reference' => $datamatrix,
                'is_cod' => false,
                'is_rush' => true,
                'amount' => (int)$cod,
                'type' => TypeEnums::N1FS->value,
                'incoming_id' => $this->incoming->id,
                'customer' => '',
                'origin' => OriginEnums::OTHER->value,
            ]);
        }
        Notification::make()
            ->title('Plate created and saved successfully')
            ->warning()
            ->seconds(2)
            ->send();
        $this->cod_is_disable = true;
        $this->datamatrix = '';
        $this->cod = '';
        $this->emit('focusDatamatrix');
    }


    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        return Plate::where('incoming_id', $this->incoming->id)->OrderBy('created_at', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('reference')
                ->searchable()
                ->sortable()
                ->url(fn (Plate $record): string => route('filament.resources.plates.edit', ['record' => $record])),
            Tables\Columns\BooleanColumn::make('is_cod'),
            Tables\Columns\BooleanColumn::make('is_rush'),
            Tables\Columns\TextColumn::make('amount')->money('eur', true),
            Tables\Columns\TextColumn::make('customer')->searchable()->sortable(),
        ];
    }


    public function render()
    {
        return view('livewire.incoming-plate');
    }
}
