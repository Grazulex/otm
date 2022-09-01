<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomings extends ListRecords
{
    protected static string $resource = IncomingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
