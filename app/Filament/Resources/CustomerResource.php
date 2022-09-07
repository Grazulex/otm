<?php

namespace App\Filament\Resources;

use App\Enums\DeliveryTypeEnums;
use App\Enums\LocationReportTypeEnums;
use App\Enums\ProcessTypeEnums;
use App\Enums\TypeEnums;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationGroup = 'Customers';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Name & ref')
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('enum_ref')
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Configuration')
                    ->schema([
                        Forms\Components\Select::make('delivery_type')->required()->options(DeliveryTypeEnums::class)->searchable(),
                        Forms\Components\Select::make('process_type')->required()->options(ProcessTypeEnums::class)->searchable(),
                        Forms\Components\Select::make('location_report_type')->required()->options(LocationReportTypeEnums::class)->searchable(),
                        Forms\Components\Select::make('plate_type')->required()->options(TypeEnums::class)->searchable(),
                        Forms\Components\Toggle::make('is_delivery_grouped')
                            ->required(),
                        Forms\Components\Toggle::make('is_delivery_bpost')
                            ->required(),
                        Forms\Components\Toggle::make('is_inmotiv_customer')
                            ->required(),

                    ])->columns(4),
                Forms\Components\Section::make('Delivery Location')
                    ->schema([
                        Forms\Components\TextInput::make('delivery_key')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_contact')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_street')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_number')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_box')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_zip')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('delivery_city')
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('process_file'),

                    ])->columns(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\BadgeColumn::make('delivery_type'),
                Tables\Columns\BooleanColumn::make('is_inmotiv_customer'),
                Tables\Columns\TextColumn::make('process_type'),
                Tables\Columns\BadgeColumn::make('items_count')->counts('items'),
                Tables\Columns\BadgeColumn::make('incomings_count')->counts('incomings'),

            ])
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
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
