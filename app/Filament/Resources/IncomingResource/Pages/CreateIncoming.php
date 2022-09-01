<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use App\Filament\Resources\IncomingResource\Widgets\PlateOverview;
use App\Models\Customer;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard\Step;
use Str;

class CreateIncoming extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = IncomingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Customer')
                ->description('Choice your customer')
                ->schema([
                    Select::make('customer_id')
                        ->options(Customer::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ]),
            Step::make('COD')
                ->description('Scan now the COD plates')
                ->schema([
                    TextInput::make('datamatrix')
                        ->label('Datamatrix (square)')
                        ->columnSpan('1/2'),
                    TextInput::make('cod')
                        ->label('COD barcode (up)')
                        ->columnSpan('1/2')
                ]),
            Step::make('NON-COD')
                ->description('SCAN now the NON-COD plates')
                ->schema([
                    TextInput::make('datamatrix')
                        ->label('Datamatrix (square)')
                        ->columnSpan('1/2'),
                ]),
            Step::make('RUSH')
                ->description('SCAN now the RUSH plates')
                ->schema([
                    TextInput::make('datamatrix')
                        ->label('Datamatrix (square)')
                        ->columnSpan('1/2'),
                    TextInput::make('cod')
                        ->label('COD barcode (up)')
                        ->columnSpan('1/2')
                ]),
        ];
    }


    protected function getFooterWidgets(): array
    {
        return [
            PlateOverview::class,
        ];
    }
}
