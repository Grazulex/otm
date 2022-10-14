<?php

namespace App\Filament\Widgets;

use App\Enums\OriginEnums;
use App\Enums\TypeEnums;
use App\Models\Plate;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductionWeekChart extends LineChartWidget
{
    protected static ?string $heading = 'Orders this month';

    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $dataTotal = Trend::query(Plate::whereIn('type', TypeEnums::cases()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count('*');

        $dataEshop = Trend::query(Plate::where('origin', OriginEnums::ESHOP->value)->whereIn('type', TypeEnums::cases()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count('*');

        $dataInmotiv = Trend::query(Plate::where('origin', OriginEnums::INMOTIV->value)->whereIn('type', TypeEnums::cases()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count('*');

        $dataOther = Trend::query(Plate::where('origin', OriginEnums::OTHER->value)->whereIn('type', TypeEnums::cases()))
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count('*');

        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'borderColor' => '#00a65a',
                    'data' => $dataTotal->map(fn (TrendValue $value) => $value->aggregate),
                ],
                [
                    'label' => 'Eshop',
                    'borderColor' => '#666CEC',
                    'data' => $dataEshop->map(fn (TrendValue $value) => $value->aggregate),
                ],
                [
                    'label' => 'Inmotiv',
                    'borderColor' => '#E7A73E',
                    'data' => $dataInmotiv->map(fn (TrendValue $value) => $value->aggregate),
                ],
                [
                    'label' => 'Other',
                    'borderColor' => '#E73E88',
                    'data' => $dataOther->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $dataTotal->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
