<?php

namespace App\Filament\Resources\CloseResource\Pages;

use App\Filament\Resources\CloseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCloses extends ListRecords
{
    protected static string $resource = CloseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
