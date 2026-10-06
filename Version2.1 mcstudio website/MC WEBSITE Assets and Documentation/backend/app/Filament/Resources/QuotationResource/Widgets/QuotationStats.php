<?php

namespace App\Filament\Resources\QuotationResource\Widgets;

use App\Models\Quotation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class QuotationStats extends BaseWidget
{
    protected function getCards(): array
    {
        $model = auth()->user()->can(['create quotations', 'delete quotations'])
        ? Quotation::query()
        : Quotation::authUser();

        $quoteData = Trend::model(Quotation::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Card::make('Quotation', $model->count())
                ->chart(
                    $quoteData
                        ->map(fn (TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Card::make('Open Quotation', $model->whereIn('status', ['new', 'processing'])->count()),
            Card::make('Average price', number_format($model->avg('total_price'), 2)),
        ];
    }
}
