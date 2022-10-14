<?php

namespace App\Filament\Resources\PlateResource\Pages;

use App\Filament\Resources\PlateResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlate extends CreateRecord
{
    protected static string $resource = PlateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
