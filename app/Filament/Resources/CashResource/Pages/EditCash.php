<?php

namespace App\Filament\Resources\CashResource\Pages;

use App\Filament\Resources\CashResource;
use App\Models\Cash;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCash extends EditRecord
{
    protected static string $resource = CashResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(function () {
                $cashes = Cash::orderBy('created_at', 'asc')->get();
                $total = 0;
                foreach ($cashes as $cash) {
                    $total = $total + $cash->amount;
                    $cash->total = $total;
                    $cash->update();
                }
            }),
        ];
    }

    protected function afterSave(): void
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
