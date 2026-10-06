<?php

namespace App\Filament\Resources\PurchaseOrderResource\Widgets;

use App\Models\PurchaseOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PurchaseOrderStats extends BaseWidget
{
    protected function getCards(): array
    {
        $model = auth()->user()->can(['create purchase orders', 'delete purchase orders'])
        ? PurchaseOrder::query()
        : PurchaseOrder::authUser();

        $PurchaseOrderData = Trend::model(PurchaseOrder::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Card::make('Purchase Orders', $model->count())
                ->chart(
                    $PurchaseOrderData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make('Open Purchase Orders', $model->whereIn('status', ['open', 'processing'])->count()),
            Card::make('Average price', number_format($model->avg('total_price'), 2)),
        ];
    }
}
