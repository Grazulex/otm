<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingResource\Pages;
use App\Filament\Resources\IncomingResource\RelationManagers;
use App\Models\Incoming;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomingResource extends Resource
{
    protected static ?string $model = Incoming::class;

    protected static ?string $navigationGroup = 'Plates';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

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
                    ->dateTime()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('customer.name'),
                Tables\Columns\BadgeColumn::make('plates_count')->counts('plates'),
                Tables\Columns\TextColumn::make('close.created_at')->dateTime()->sortable()->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListIncomings::route('/'),
            'create' => Pages\CreateIncoming::route('/create'),
            'view' => Pages\ViewIncoming::route('/{record}')
        ];
    }
}
