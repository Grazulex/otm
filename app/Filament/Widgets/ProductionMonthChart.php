<?php

namespace App\Filament\Widgets;

use App\Enums\OriginEnums;
use App\Models\Plate;
use App\Models\Production;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ProductionMonthChart extends LineChartWidget
{
    protected static ?string $heading = 'Orders this year';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $dataTotal = Trend::model(Plate::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count('*');

        $dataEshop = Trend::query(Plate::where('origin', OriginEnums::ESHOP->value))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count('*');

        $dataInmotiv = Trend::query(Plate::where('origin', OriginEnums::INMOTIV->value))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
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
            ],
            'labels' => $dataTotal->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
