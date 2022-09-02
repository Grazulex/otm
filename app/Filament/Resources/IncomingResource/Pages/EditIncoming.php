<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use App\Filament\Resources\IncomingResource\Widgets\PlateOverview;
use App\Models\Customer;
use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\EditRecord\Concerns\HasWizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Wizard\Step;
use Str;
use Filament\Forms;
use Filament\Resources\Form;

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
