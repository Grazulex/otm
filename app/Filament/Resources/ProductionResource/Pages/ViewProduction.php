<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Filament\Resources\ProductionResource\Widgets\PlateOverview;
use Filament\Resources\Pages\ViewRecord;

class ViewProduction extends ViewRecord
{
    protected static string $resource = ProductionResource::class;

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
