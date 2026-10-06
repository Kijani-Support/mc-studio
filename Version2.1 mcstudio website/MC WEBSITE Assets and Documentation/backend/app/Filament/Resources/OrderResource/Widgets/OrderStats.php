<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderStats extends BaseWidget
{
    protected function getCards(): array
    {
        $model = auth()->user()->can(['create orders', 'delete orders']) 
        ? Order::query() 
        : Order::authUser();

        $orderData = Trend::model(Order::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Card::make('Orders', $model->get()->count())
                ->chart(
                    $orderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make('Open orders', $model->whereIn('status', ['new', 'processing'])->count()),
            Card::make('Average price', number_format($model->avg('total_price'), 2)),
        ];
    }
}
