<?php

namespace App\Filament\Resources\CloseResource\Widgets;

use App\Models\Cash;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CashOverview extends BaseWidget
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
            return Cash::where('close_id', $this->record->id)->orderBy('created_at', 'desc');
        } else {
            return Cash::whereNull('close_id')->orderBy('created_at', 'desc');
        }
    }
 
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
            ->dateTime(),
            Tables\Columns\TextColumn::make('user.name'),
            Tables\Columns\TextColumn::make('amount')->money('eur', true),
        ];
    }
}
