<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackResource\Pages;
use App\Models\Back;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class BackResource extends Resource
{
    protected static ?string $model = Back::class;

    protected static ?string $navigationGroup = 'Plates';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-backspace';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('plates_count')->counts(
                    'plates',
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
            ->actions([
            ])
            ->bulkActions([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBacks::route('/'),
            'create' => Pages\CreateBack::route('/create'),
            'edit' => Pages\EditBack::route('/{record}/edit'),
        ];
    }
}
