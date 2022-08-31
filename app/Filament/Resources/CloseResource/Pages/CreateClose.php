<?php

namespace App\Filament\Resources\CloseResource\Pages;

use App\Filament\Resources\CloseResource;
use App\Filament\Resources\CloseResource\Widgets\CashOverview;
use App\Filament\Resources\CloseResource\Widgets\IncomingOverview;
use App\Filament\Resources\CloseResource\Widgets\ReceptionOverview;
use App\Models\Cash;
use App\Models\Incoming;
use App\Models\Reception;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateClose extends CreateRecord
{
    protected static string $resource = CloseResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterFill(): void
    {
        $diff=0;

        $receptions = Reception::whereNull('close_id')->get();
        foreach ($receptions as $reception) {
            $diff=$diff - $reception->amount_cash;
        }

        $incomings = Incoming::whereNull('close_id')
            ->withSum(['plates as cod_plates_sum'=> function ($query) {
                $query->where('is_cod', true);
            }], 'amount')
            ->get();

        foreach ($incomings as $incoming) {
            $diff=$diff + $incoming->cod_plates_sum;
        }

        $this->data['diff']= $diff;
    }

    protected function afterCreate(): void
    {
        $cashes = Cash::whereNull('close_id')->get();
        foreach ($cashes as $cash) {
            $cash->close_id = $this->record->id;
            $cash->update();
        }

        $receptions = Reception::whereNull('close_id')->get();
        foreach ($receptions as $reception) {
            $reception->close_id = $this->record->id;
            $reception->update();
        }

        $incomings = Incoming::whereNull('close_id')->get();
        foreach ($incomings as $incoming) {
            $incoming->close_id = $this->record->id;
            $incoming->update();
        }
    }


    protected function getHeaderWidgets(): array
    {
        return [
            ReceptionOverview::class,
            IncomingOverview::class,
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            CashOverview::class,
        ];
    }    
}
