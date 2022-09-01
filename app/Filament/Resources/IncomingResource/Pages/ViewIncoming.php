<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use App\Filament\Resources\ProductionResource\Widgets\PlateOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncoming extends ViewRecord
{
    protected static string $resource = IncomingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            //
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            PlateOverview::class,
        ];
    }
}
