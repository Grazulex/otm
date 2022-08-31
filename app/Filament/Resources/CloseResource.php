<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CloseResource\Pages;
use App\Filament\Resources\CloseResource\RelationManagers;
use App\Filament\Resources\CloseResource\Widgets\CashOverview;
use App\Filament\Resources\CloseResource\Widgets\IncomingOverview;
use App\Filament\Resources\CloseResource\Widgets\ReceptionOverview;
use App\Models\Close;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CloseResource extends Resource
{
    protected static ?string $model = Close::class;
    protected static ?string $navigationGroup = 'Cash ledgers';

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('diff')->numeric()->prefix("€")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()->sortable()->searchable(),
                Tables\Columns\BadgeColumn::make('cashes_count')->counts('cashes'),
                Tables\Columns\BadgeColumn::make('receptions_count')->counts('receptions'),
                Tables\Columns\BadgeColumn::make('incomings_count')->counts('incomings'),
                Tables\Columns\TextColumn::make('diff')->money('eur', true),
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
            'index' => Pages\ListCloses::route('/'),
            'create' => Pages\CreateClose::route('/create'),
            'edit' => Pages\EditClose::route('/{record}/edit'),
        ];
    }   

    public static function getWidgets(): array
    {
        return [
            CashOverview::class,
            ReceptionOverview::class,
            IncomingOverview::class,
        ];
    }
    
}
