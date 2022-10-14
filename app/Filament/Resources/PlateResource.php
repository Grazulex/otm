<?php

namespace App\Filament\Resources;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Filament\Resources\PlateResource\Pages;
use App\Models\Plate;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;

class PlateResource extends Resource
{
    protected static ?string $model = Plate::class;

    protected static ?string $navigationGroup = 'Plates';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('production_id')
            ->whereIn('type', TypeEnums::cases())
            ->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Main fields')
                ->schema([
                    Forms\Components\DateTimePicker::make(
                        'created_at',
                    )->required(),
                    Forms\Components\TextInput::make('reference')
                        ->required()
                        ->maxLength(25),
                    Forms\Components\Select::make('type')
                        ->required()
                        ->options(TypeEnums::class)
                        ->searchable(),
                    Forms\Components\Select::make('origin')
                        ->required()
                        ->options(OriginEnums::class)
                        ->searchable(),
                ])
                ->columns(4),
            Forms\Components\Section::make('Customer')
                ->schema([
                    Forms\Components\TextInput::make('order_id')->maxLength(
                        255,
                    ),
                    Forms\Components\TextInput::make('customer_key')->maxLength(
                        255,
                    ),
                    Forms\Components\TextInput::make('customer')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('amount')->prefix('€'),
                ])
                ->columns(4),
            Forms\Components\Section::make('Configurations')
                ->schema([
                    Forms\Components\Toggle::make('is_cod')->required(),
                    Forms\Components\Toggle::make('is_rush')->required(),
                    Forms\Components\Toggle::make('is_incoming')->required(),
                    Forms\Components\TextInput::make('plate_type')->maxLength(
                        255,
                    ),
                    Forms\Components\TextInput::make('product_type')->maxLength(
                        255,
                    ),
                ])
                ->columns(3),
            Forms\Components\Section::make('Datas')
                ->schema([
                    Forms\Components\KeyValue::make('datas')
                        ->keyLabel('Type')
                        ->valueLabel('Value')
                        ->required(),
                ])
                ->columns(1),
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
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('origin')
                    ->colors([
                        'danger' => OriginEnums::ESHOP->value,
                        'success' => OriginEnums::INMOTIV->value,
                        'warning' => OriginEnums::OTHER->value,
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('production.created_at'),
                Tables\Columns\TextColumn::make('incoming.created_at'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('is_producted')
                    ->label('Waiting for production')
                    ->default()
                    ->query(
                        fn (Builder $query): Builder => $query->whereNull(
                            'production_id',
                        ),
                    ),
                Filter::make('is_incoming')
                    ->label('Waiting for Bpost')
                    ->query(
                        fn (Builder $query): Builder => $query
                            ->where('is_incoming', true)
                            ->whereNull('incoming_id'),
                    ),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
