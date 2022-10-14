<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class LabelsRelationManager extends RelationManager
{
    protected static string $relationship = 'labels';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(
                    'delivery_contact',
                )->maxLength(255),
                Forms\Components\TextInput::make(
                    'delivery_street',
                )->maxLength(255),
                Forms\Components\TextInput::make(
                    'delivery_number',
                )->maxLength(255),
                Forms\Components\TextInput::make('delivery_box')->maxLength(
                    255,
                ),
                Forms\Components\TextInput::make('delivery_zip')->maxLength(
                    255,
                ),
                Forms\Components\TextInput::make(
                    'delivery_city',
                )->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('delivery_contact'),
                Tables\Columns\TextColumn::make('delivery_street'),
                Tables\Columns\TextColumn::make('delivery_number'),
                Tables\Columns\TextColumn::make('delivery_box'),
                Tables\Columns\TextColumn::make('delivery_zip'),
                Tables\Columns\TextColumn::make('delivery_city'),
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
