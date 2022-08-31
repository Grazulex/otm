<?php

namespace App\Filament\Resources\ReceptionResource\Pages;

use App\Filament\Resources\ReceptionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReceptions extends ListRecords
{
    protected static string $resource = ReceptionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
