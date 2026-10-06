<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\LineChartWidget;
use DB;

class OrdersChart extends LineChartWidget
{
    protected static ?string $heading = 'Orders per month';

    protected static ?int $sort = 1;

    public ?string $filter = 'year';

    protected function getFilters(): ?array
    {
        return [
            'year' => now()->format('Y'),
            'last_year' => now()->subYear()->format('Y'),
            'two_years' => now()->subYears(2)->format('Y'),
            'three_years' => now()->subYears(3)->format('Y'),
        ];
    }

    
    protected function getData(): array
    {
        $activeFilter = $this->filter;

        switch($activeFilter){
            case 'year':
                $start_time = now()->startOfYear();
                $end_time = now()->endOfYear();
                break;
            case 'last_year':
                $start_time = now()->subYear()->startOfYear();
                $end_time = now()->subYear()->endOfYear();
                break;
            case 'two_years':
                $start_time = now()->subYears(2)->startOfYear();
                $end_time = now()->subYears(2)->endOfYear();
                break;
            case 'three_years':
                $start_time = now()->subYears(3)->startOfYear();
                $end_time = now()->subYears(3)->endOfYear();
                break;
            default:
                $start_time = now()->startOfYear();
                $end_time = now()->endOfYear();
                break;
        }

        $query = auth()->user()->hasRole(['Admin', 'Employee']) ? Order::query() : Order::where('user_id', authID());
        
        $data = Trend::query($query)
            ->between(
                start: $start_time,
                end: $end_time,
            )
            ->perMonth()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' =>  $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
