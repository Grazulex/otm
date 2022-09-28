<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceptionResource\Pages;
use App\Models\Reception;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ReceptionResource extends Resource {
    protected static ?string $model = Reception::class;

    protected static ?string $navigationGroup = 'Cash ledgers';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\TextInput::make('amount_cash')
                ->numeric()
                ->prefix('€')
                ->required(),
            Forms\Components\TextInput::make('amount_bbc')
                ->numeric()
                ->prefix('€')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount_cash')->money(
                    'eur',
                    true,
                ),
                Tables\Columns\TextColumn::make('amount_bbc')->money(
                    'eur',
                    true,
                ),
                Tables\Columns\TextColumn::make('close.created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array {
        return [
                //
            ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListReceptions::route('/'),
            'create' => Pages\CreateReception::route('/create'),
            'edit' => Pages\EditReception::route('/{record}/edit'),
        ];
    }
}
