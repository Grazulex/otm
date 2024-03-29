<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingResource\Pages;
use App\Models\Customer;
use App\Models\Incoming;
use App\Services\IncomingService;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Collection;

class IncomingResource extends Resource
{
    protected static ?string $model = Incoming::class;

    protected static ?string $navigationGroup = 'Plates';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('customer_id')
                ->options(Customer::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\BadgeColumn::make('plates_count')->counts(
                    'plates',
                ),
                Tables\Columns\TextColumn::make('amount')->money('eur', true),
                Tables\Columns\TextColumn::make('close.created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('printLabelBelfius')
                    ->label(__('Label Co2'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $incomingService = new IncomingService($record);
                            echo $incomingService->makeLabelBelfius();
                        },
                            'label.pdf');
                    })
                    ->tooltip(__('Print Label Co2'))
                    ->visible(
                        fn (Incoming $record): bool => $record->customer
                            ->need_co2_label,
                    )
                    ->icon('heroicon-s-printer')
                    ->color('primary'),
                Tables\Actions\Action::make('printLabelKbc')
                    ->label(__('Label Order'))
                    ->action(function ($record) {
                        return response()->streamDownload(function () use (
                            $record,
                        ) {
                            $incomingService = new IncomingService($record);
                            echo $incomingService->makeLabelKbc();
                        },
                            'label.pdf');
                    })
                    ->tooltip(__('Print Order Label'))
                    ->visible(
                        fn (Incoming $record): bool => $record->customer
                            ->need_order_label,
                    )
                    ->icon('heroicon-s-printer')
                    ->color('primary'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('bpost')
                    ->label(__('Bpost file'))
                    ->icon('heroicon-s-check-circle')
                    ->action(function (Collection $records) {
                        return response()->streamDownload(function () use (
                            $records,
                        ) {
                            $bpost = null;
                            $i = 0;
                            foreach ($records as $record) {
                                $incomingService = new IncomingService($record);
                                if ($i == 0) {
                                    $bpost = $incomingService->makeBpostFile();
                                } else {
                                    $bpost .= $incomingService->makeBpostFile(false);
                                }
                                $i++;
                            }
                            echo $bpost;
                        },

                            'bpost.csv');
                    })
                    ->deselectRecordsAfterCompletion(),

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncomings::route('/'),
            'create' => Pages\CreateIncoming::route('/create'),
            'edit' => Pages\EditIncoming::route('/{record}/edit'),
        ];
    }
}
