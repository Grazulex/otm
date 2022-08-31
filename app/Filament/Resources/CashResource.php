<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashResource\Pages;
use App\Filament\Resources\CashResource\RelationManagers;
use App\Models\Cash;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashResource extends Resource
{
    protected static ?string $model = Cash::class;

    protected static ?string $navigationGroup = 'Cash ledgers';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-cash';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('amount')->numeric()->prefix("€")
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('amount')->money('eur', true),
                Tables\Columns\TextColumn::make('comment')->searchable(),
                Tables\Columns\TextColumn::make('total')->money('eur', true),
                Tables\Columns\TextColumn::make('close.created_at')->dateTime()->sortable()->searchable(),
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
            'index' => Pages\ListCashes::route('/'),
            'create' => Pages\CreateCash::route('/create'),
            'edit' => Pages\EditCash::route('/{record}/edit'),
        ];
    }
}
