<?php

namespace App\Filament\Resources\ProductionResource\Widgets;

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


    public function isTableSearchable(): bool
    {
        return false;
    }

    protected function isTablePaginationEnabled(): bool 
    {
        return false;
    } 

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
            Tables\Columns\TextColumn::make('reference'),
            Tables\Columns\TextColumn::make('type'),
            Tables\Columns\TextColumn::make('origin'),
            Tables\Columns\TextColumn::make('customer'),
        ];
    }
}

