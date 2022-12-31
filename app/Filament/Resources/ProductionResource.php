<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\Widgets\PlateOverview;
use App\Models\Production;
use App\Services\ProductionService;
use Carbon\Carbon;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationGroup = 'Plates';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('plates_count')->counts(
                    'plates',
                ),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('downloadBposFile')
                    ->label(__('Bpost File'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makeBpostFile();
                        },
                            'Bpost_'.Carbon::createFromDate($record->created_at)->format('Ymd_Hi').'.xlsx');
                    })
                    ->tooltip(__('Download'))
                    ->icon('heroicon-o-truck')
                    ->color('primary'),
                Tables\Actions\Action::make('printLabelCod')
                    ->label(__('COD letter'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makeLetterCod();
                        },
                            'Cod_'.Carbon::createFromDate($record->created_at)->format('Ymd_Hi').'.pdf');
                    })
                    ->tooltip(__('Print COD Leter'))
                    ->visible(
                        fn (Production $record): bool => $record->is_bpost && $record->have_cod,
                    )
                    ->icon('heroicon-s-book-open')
                    ->color('primary'),
                Tables\Actions\Action::make('printPickings')
                    ->label(__('Picking list'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makePicking();
                        },
                            'Pick_'.Carbon::createFromDate($record->created_at)->format('Ymd_Hi').'.pdf');
                    })
                    ->tooltip(__('Print Picking list'))
                    ->visible(
                        fn (Production $record): bool => $record->is_bpost && $record->have_picking,
                    )
                    ->icon('heroicon-s-archive')
                    ->color('primary'),
                Tables\Actions\Action::make('printShipping')
                    ->label(__('Shipping list'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makeShipping();
                        },
                            'Ship_'.Carbon::createFromDate($record->created_at)->format('Ymd_Hi').'.pdf');
                    })
                    ->tooltip(__('Print Shipping list'))
                    ->visible(
                        fn (Production $record): bool => $record->is_bpost && $record->have_shipping,
                    )
                    ->icon('heroicon-s-archive')
                    ->color('primary'),
                Tables\Actions\Action::make('exportAsJson')
                    ->label(__('Production file'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $productionService = new ProductionService($record);
                            echo $productionService->makeCsv();
                        },
                            'Prod_'.Carbon::createFromDate($record->created_at)->format('Ymd_Hi').'.xlsx');
                    })
                    ->tooltip(__('Export production file'))
                    ->visible(
                        fn (Production $record): bool => $record->is_bpost,
                    )
                    ->icon('heroicon-s-download')
                    ->color('primary'),
            ])
            ->bulkActions([
                
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
            'view' => Pages\ViewProduction::route('/{record}'),
        ];
    }

    public static function getWidgets(): array
    {
        return [PlateOverview::class];
    }
}
