<?php

namespace App\Filament\Resources;

use App\Enums\OriginEnums;
use App\Filament\Resources\PlateResource\Pages;
use App\Filament\Resources\PlateResource\RelationManagers;
use App\Models\Plate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlateResource extends Resource
{
    protected static ?string $model = Plate::class;

    protected static ?string $navigationGroup = 'Plates';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('production_id'),
                Forms\Components\TextInput::make('incoming_id'),
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('order_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('customer_key')
                    ->maxLength(255),
                Forms\Components\TextInput::make('customer')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('origin')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('amount'),
                Forms\Components\Toggle::make('is_cod')
                    ->required(),
                Forms\Components\Toggle::make('is_rush')
                    ->required(),
                Forms\Components\TextInput::make('datas'),
                Forms\Components\Toggle::make('is_incoming')
                    ->required(),
                Forms\Components\TextInput::make('plate_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_type')
                    ->maxLength(255),
                Forms\Components\TextInput::make('client_code')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('reference')->searchable()->sortable(),   
                Tables\Columns\BadgeColumn::make('origin')
                    ->colors([
                        'danger' => OriginEnums::ESHOP->value,
                        'success' => OriginEnums::INMOTIV->value,
                    ])->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('customer')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('production.created_at'),
                Tables\Columns\TextColumn::make('incoming.created_at'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPlates::route('/'),
            'create' => Pages\CreatePlate::route('/create'),
            'edit' => Pages\EditPlate::route('/{record}/edit'),
        ];
    }    
}
