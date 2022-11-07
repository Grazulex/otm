<?php

namespace App\Filament\Resources\BackResource\Pages;

use App\Filament\Resources\BackResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBacks extends ListRecords
{
    protected static string $resource = BackResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
