<?php

namespace App\Filament\Resources\BackResource\Pages;

use App\Filament\Resources\BackResource;
use Filament\Resources\Pages\EditRecord;

class EditBack extends EditRecord
{
    protected static string $resource = BackResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFooterWidgets(): array
    {
        return [
            BackResource\Widgets\PlatesOverview::class,
        ];
    }

}
