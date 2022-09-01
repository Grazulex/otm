<?php

namespace App\Filament\Resources\ProductionResource\Widgets;

use App\Enums\OriginEnums;
use App\Models\Plate;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PlateOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public ?Model $record = null;


    protected function getTableQuery(): Builder
    {
        if ($this->record) {
            return Plate::where('production_id', $this->record->id)->orderBy('created_at', 'desc');
        } else {
            return Plate::whereNull('production_id')->orderBy('created_at', 'desc');
        }
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()->searchable()->sortable(),
            Tables\Columns\TextColumn::make('reference')
                ->searchable()
                ->sortable()
                ->url(fn (Plate $record): string => route('filament.resources.plates.edit', ['record' => $record])),
            Tables\Columns\BadgeColumn::make('origin')
                ->colors([
                    'danger' => OriginEnums::ESHOP->value,
                    'success' => OriginEnums::INMOTIV->value,
                ])->searchable()->sortable(),
            Tables\Columns\TextColumn::make('type')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('order_id')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('customer')->searchable()->sortable(),
        ];
    }
}
