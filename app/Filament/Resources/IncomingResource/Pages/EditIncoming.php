<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use Filament\Resources\Pages\EditRecord;

class EditIncoming extends EditRecord
{
    protected static string $resource = IncomingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFooterWidgets(): array
    {
        return [
            IncomingResource\Widgets\PlatesOverview::class,
        ];
    }
}
