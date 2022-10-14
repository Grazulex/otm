<?php

namespace App\Filament\Resources\PlateResource\Pages;

use App\Filament\Resources\PlateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlates extends ListRecords
{
    protected static string $resource = PlateResource::class;

    protected ?string $maxContentWidth = 'full';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
