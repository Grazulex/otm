<?php

namespace App\Filament\Resources\CashResource\Pages;

use App\Filament\Resources\CashResource;
use App\Models\Cash;
use Filament\Resources\Pages\CreateRecord;

class CreateCash extends CreateRecord
{
    protected static string $resource = CashResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $cashes = Cash::orderBy('created_at', 'asc')->get();
        $total = 0;
        foreach ($cashes as $cash) {
            $total = $total + $cash->amount;
            $cash->total = $total;
            $cash->update();
        }
    }
}
