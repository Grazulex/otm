<?php

namespace App\Filament\Widgets;

use App\Enums\TypeEnums;
use App\Models\Plate;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class StatsOverview extends BaseWidget
{

    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Plates ready for prod', Plate::whereNull('production_id')->whereIn('type', TypeEnums::cases())->count()),
            Card::make(
                'Plates prod the last 24 hours',
                Plate::with('production')
                    ->whereHas('production', function ($query) {
                        $query->where('created_at', '>', Carbon::now()->subDays(1));
                    })
                    ->whereIn('type', TypeEnums::cases())
                    ->count()
            ),
            Card::make(
                'Plates prod the last 7 days',
                Plate::with('production')
                    ->whereHas('production', function ($query) {
                        $query->where('created_at', '>', Carbon::now()->subDays(7));
                    })
                    ->whereIn('type', TypeEnums::cases())
                    ->count()
            ),
            Card::make('Bpost plates coming', Plate::where('is_incoming', 1)->whereNull('incoming_id')->whereIn('type', TypeEnums::cases())->count()),
            Card::make(
                'Plates shipped (last 24 hours)',
                0
            ),
            Card::make(
                'Plates shipped (last 7 days)',
                0
            )
        ];
    }
}
