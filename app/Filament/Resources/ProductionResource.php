<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers;
use App\Filament\Resources\ProductionResource\Widgets\PlateOverview;
use App\Models\Production;
use App\Services\ProductionService;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Str;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationGroup = 'Plates';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\BadgeColumn::make('plates_count')->counts('plates'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('exportAsJson')
                    ->label(__('Export'))
                    ->action(function ($record, ProductionService $productionService) {
                        return response()->streamDownload(function () use ($record, $productionService) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makeCsv();
                        }, 'production.csv');
                    })
                    ->tooltip(__('Export'))
                    ->icon('heroicon-s-download')
                    ->color('primary'),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductions::route('/'),
            'view' => Pages\ViewProduction::route('/{record}')
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PlateOverview::class,
        ];
    }
}
