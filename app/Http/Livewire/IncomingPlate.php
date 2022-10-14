<?php

namespace App\Http\Livewire;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Models\Customer;
use App\Models\Incoming;
use App\Models\Plate;
use Filament\Notifications\Notification;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class IncomingPlate extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public Incoming $incoming;

    public $plates;

    public string $datamatrix;

    public string $cod;

    public string $type;

    public bool $cod_is_disable;

    protected int|string|array $columnSpan = 'full';

    public function mount()
    {
        $this->datamatrix = '';
        $this->cod = '';
        $this->type = 'cod';
        $this->cod_is_disable = true;
    }

    public function searchDatamatrix()
    {
        $datamatrix = strtoupper(
            trim(
                preg_replace(
                    '/[^a-z0-9]+/i',
                    '',
                    substr(trim($this->datamatrix), 0, 10),
                ),
            ),
        );
        if ($this->type == 'cod') {
            $is_cod = true;
            $is_rush = false;
        } elseif ($this->type == 'rush') {
            $is_cod = false;
            $is_rush = true;
        } else {
            $is_cod = false;
            $is_rush = false;
        }
        $plate = Plate::where('reference', $datamatrix)
            ->where('incoming_id', $this->incoming->id)
            ->whereIn('type', TypeEnums::cases())
            ->where('is_cod', $is_cod)
            ->where('is_rush', $is_rush)
            ->first();
        if (! $plate) {
            if (! $is_cod && ! $is_rush) {
                $plate = Plate::where('reference', $datamatrix)
                    ->whereNull('incoming_id')
                    ->whereNull('production_id')
                    ->whereIn('type', TypeEnums::cases())
                    ->first();
                if ($plate) {
                    $plate->incoming_id = $this->incoming->id;
                    $plate->is_cod = false;
                    $plate->is_rush = false;
                    $plate->save();
                    Notification::make()
                        ->title('Plate finded and updated successfully')
                        ->success()
                        ->seconds(2)
                        ->send();
                    $this->cod_is_disable = true;
                    $this->datamatrix = '';
                    $this->cod = '';
                    $this->emit('focusDatamatrix');
                } else {
                    $this->createPlate(
                        customer: $this->incoming->customer,
                        reference: $datamatrix,
                        amount: 0,
                        is_cod: false,
                        is_rush: false,
                    );
                    $this->cod_is_disable = true;
                    $this->datamatrix = '';
                    $this->cod = '';
                    $this->emit('focusDatamatrix');
                    Notification::make()
                        ->title('Plate created and saved successfully')
                        ->warning()
                        ->seconds(2)
                        ->send();
                }
            } else {
                $this->cod_is_disable = false;
                $this->emit('focusCod');
            }
        } else {
            Notification::make()
                ->title('Plate is already in this incoming!')
                ->danger()
                ->seconds(2)
                ->send();
            $this->cod_is_disable = true;
            $this->datamatrix = '';
            $this->cod = '';
            $this->emit('focusDatamatrix');
        }
    }

    public function searchCod()
    {
        $datamatrix = preg_replace(
            '/[^a-z0-9]+/i',
            '',
            substr(trim($this->datamatrix), 0, 10),
        );
        $cod = (int) substr(trim($this->cod), 4, 6) / 100;
        if ($this->type == 'cod') {
            $is_cod = true;
            $is_rush = false;
        } elseif ($this->type == 'rush') {
            $is_cod = false;
            $is_rush = true;
        } else {
            $is_cod = false;
            $is_rush = false;
        }
        $plate = Plate::where('reference', $datamatrix)
            ->whereNull('incoming_id')
            ->whereNull('production_id')
            ->whereIn('type', TypeEnums::cases())
            ->first();
        if ($plate) {
            $plate->incoming_id = $this->incoming->id;
            $plate->is_cod = $is_cod;
            $plate->is_rush = $is_rush;
            $plate->amount = (int) $cod;
            $plate->save();
        } else {
            if ($this->type == 'cod') {
                $this->createPlate(
                    customer: $this->incoming->customer,
                    reference: $datamatrix,
                    amount: (int) $cod,
                    is_cod: true,
                    is_rush: false,
                );
            } else {
                $this->createPlate(
                    customer: $this->incoming->customer,
                    reference: $datamatrix,
                    amount: (int) $cod,
                    is_cod: false,
                    is_rush: true,
                );
            }
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

    public function createPlate(
        Customer $customer,
        string $reference,
        int $amount = 0,
        bool $is_cod = false,
        bool $is_rush = false,
    ) {
        if ($customer->is_delivery_grouped && $customer->delivery_contact) {
            Plate::create([
                'reference' => $reference,
                'is_cod' => $is_cod,
                'is_rush' => $is_rush,
                'amount' => (int) $amount,
                'plate_type' => $customer->plate_type,
                'product_type' => 'plates',
                'type' => $customer->plate_type,
                'incoming_id' => $this->incoming->id,
                'customer' => $customer->delivery_contact,
                'customer_key' => $customer->delivery_key,
                'origin' => OriginEnums::OTHER->value,
                'datas' => [
                    'destination_name' => $customer->delivery_contact,
                    'destination_key' => $customer->delivery_key,
                    'destination_street' => $customer->delivery_street,
                    'destination_house_number' => $customer->delivery_number,
                    'destination_bus' => $customer->delivery_box,
                    'destination_postal_code' => $customer->delivery_zip,
                    'destination_city' => $customer->delivery_city,
                ],
            ]);
        } else {
            $plate = Plate::create([
                'reference' => $reference,
                'is_cod' => $is_cod,
                'is_rush' => $is_rush,
                'amount' => (int) $amount,
                'plate_type' => $customer->plate_type,
                'product_type' => 'plates',
                'type' => $customer->plate_type,
                'incoming_id' => $this->incoming->id,
                'customer' => $customer->name,
                'origin' => OriginEnums::OTHER->value,
            ]);
        }
    }

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableQuery(): Builder
    {
        return Plate::where('incoming_id', $this->incoming->id)->OrderBy(
            'customer',
            'asc',
        )->OrderBy(
            'reference',
            'asc',
        );
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->searchable(),
            Tables\Columns\TextColumn::make('reference')
                ->searchable()
                ->url(
                    fn (Plate $record): string => route(
                        'filament.resources.plates.edit',
                        ['record' => $record],
                    ),
                ),
            Tables\Columns\IconColumn::make('is_cod')->boolean(),
            Tables\Columns\IconColumn::make('is_rush')->boolean(),
            Tables\Columns\TextColumn::make('amount')->money('eur', true),
            Tables\Columns\TextColumn::make('customer')
                ->searchable(),
            Tables\Columns\TextColumn::make('datas.owner_language')->label(
                'Language',
            ),
        ];
    }

    public function render()
    {
        return view('livewire.incoming-plate');
    }
}
