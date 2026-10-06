<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;

class CustomersChart extends LineChartWidget
{
    protected static ?string $heading = 'Customers Overview';

    protected static string $chartId = 'dashboard-customers-line-column-chart';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = null;

    public ?string $filter = '0';

    protected function getFilters(): ?array
    {
        $years = range(now()->year, 2020);

        return $years;
    }


    protected function getData(): array
    {
       
        $activeFilter = (int) $this->filter;

        $start_time = Carbon::now()->subYears($activeFilter)->startOfYear();
        $end_time   = Carbon::now()->subYears($activeFilter)->endOfYear();
        
        $data = Trend::query(User::customers())
            ->between(
                start: $start_time,
                end: $end_time,
            )
            ->perMonth()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('Admin');
    }

}
