<?php

namespace App\Filament\Resources\IncomingResource\RelationManagers;

use App\Models\Plate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class PlatesRelationManager extends RelationManager
{
    protected static string $relationship = 'plates';

    protected static ?string $recordTitleAttribute = 'reference';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->sortable()
                    ->url(fn (Plate $record): string => route('filament.resources.plates.edit', ['record' => $record])),
                Tables\Columns\BooleanColumn::make('is_cod'),
                Tables\Columns\BooleanColumn::make('is_rush'),
                Tables\Columns\TextColumn::make('amount')->money('eur', true),
                Tables\Columns\TextColumn::make('customer')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
