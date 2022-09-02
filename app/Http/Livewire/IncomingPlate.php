<?php

namespace App\Http\Livewire;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Models\Incoming;
use App\Models\Plate;
use Closure;
use Livewire\Component;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IncomingPlate extends Component  implements Tables\Contracts\HasTable
{

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
        if ($this->type == 'cod') {
            $plate = Plate::where('reference', $this->datamatrix)
                ->whereNull('incoming_id')
                ->where('is_cod', true)
                ->where('is_rush', false)
                ->first();
        } elseif ($this->type == 'rush') {
            $plate = Plate::where('reference', $this->datamatrix)
                ->whereNull('incoming_id')
                ->where('is_cod', false)
                ->where('is_rush', true)
                ->first();
        } else {
            $plate = Plate::where('reference', $this->datamatrix)
                ->whereNull('incoming_id')
                ->where('is_cod', false)
                ->where('is_rush', false)
                ->first();
        }
        if ($plate) {
            $plate->incoming_id = $this->incoming->id;
            $plate->save();
        } else {
            if ($this->type != 'cod' && $this->type != 'rush') {
                $plate = Plate::create([
                    'reference' => $this->datamatrix,
                    'is_cod' => false,
                    'is_rush' => false,
                    'type' => TypeEnums::N1FS->value,
                    'incoming_id' => $this->incoming->id,
                    'customer' => '',
                    'origin' => OriginEnums::OTHER->value,
                ]);
            }
            if ($this->type == 'cod' || $this->type == 'rush') {
                $this->cod_is_disable = false;
            }
        }
    }

    public function searchCod()
    {
        if ($this->type == 'cod') {
            $plate = Plate::create([
                'reference' => $this->datamatrix,
                'is_cod' => true,
                'is_rush' => false,
                'amount' => (int)$this->cod,
                'type' => TypeEnums::N1FS->value,
                'incoming_id' => $this->incoming->id,
                'customer' => '',
                'origin' => OriginEnums::OTHER->value,
            ]);
        } else {
            $plate = Plate::create([
                'reference' => $this->datamatrix,
                'is_cod' => false,
                'is_rush' => true,
                'amount' => (int)$this->cod,
                'type' => TypeEnums::N1FS->value,
                'incoming_id' => $this->incoming->id,
                'customer' => '',
                'origin' => OriginEnums::OTHER->value,
            ]);
        }
        $this->cod_is_disable = true;
        $this->datamatrix = '';
        $this->cod = '';
        //dd($this->cod);
    }


    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        return Plate::where('incoming_id', $this->incoming->id);
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
