<?php

namespace App\Filament\Resources\ReceptionResource\Pages;

use App\Filament\Resources\ReceptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReception extends EditRecord
{
    protected static string $resource = ReceptionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
