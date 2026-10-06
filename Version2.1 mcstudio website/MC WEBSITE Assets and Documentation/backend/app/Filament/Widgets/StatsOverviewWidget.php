<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Order;
use App\Models\User;
use App\Models\Quotation;
use Carbon\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static ?string $pollingInterval = null;

    protected function getCards(): array
    {
        $orders = Order::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $quotations = Quotation::whereMonth('created_at', Carbon::now()->month)->get()->count();
        $customers = User::customers()->whereMonth('created_at', Carbon::now()->month)->get()->count();
        return [
            // Card::make('Revenue', '$192.1k')
            //     ->description('32k increase')
            //     ->descriptionIcon('heroicon-s-trending-up')
            //   //  ->chart([7, 2, 10, 3, 15, 4, 17])
            //     ->color('success'),
            Card::make('New customers', $customers)
                //->description('3% decrease')
                ->descriptionIcon('heroicon-s-trending-down')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('success'),
            Card::make('New quotations', $quotations)
               // ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),
            Card::make('New orders', $orders)
                //->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart([15, 4, 10, 2, 12, 4, 12])
                ->color('success'),
        ];
    }
}
