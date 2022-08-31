<?php

namespace App\Filament\Resources\CloseResource\Pages;

use App\Filament\Resources\CloseResource;
use App\Filament\Resources\CloseResource\Widgets\CashOverview;
use App\Filament\Resources\CloseResource\Widgets\IncomingOverview;
use App\Filament\Resources\CloseResource\Widgets\ReceptionOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClose extends EditRecord
{
    protected static string $resource = CloseResource::class;

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

    protected function getHeaderWidgets(): array
    {
        return [
            ReceptionOverview::class,
            IncomingOverview::class,
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            CashOverview::class,
        ];
    } 
}
