<?php

namespace App\Filament\Resources\ReceptionResource\Pages;

use App\Filament\Resources\ReceptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReception extends CreateRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
