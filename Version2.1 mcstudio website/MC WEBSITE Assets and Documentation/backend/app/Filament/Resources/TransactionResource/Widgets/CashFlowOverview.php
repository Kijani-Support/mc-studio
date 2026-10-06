<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CashFlowOverview extends BaseWidget
{
    
    protected static ?int $sort = 0;

    protected function getCards(): array
    {
        return [
        Card::make('Income', Transaction::income())
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Card::make('Expenses', Transaction::expenses())
            ->descriptionIcon('heroicon-s-trending-down')
            ->chart([17, 4, 15, 3, 10, 2, 7])
            ->color('danger'),
        Card::make('Net', Transaction::net())
            ->descriptionIcon(Transaction::net() > 0 ? 'heroicon-s-trending-up' : 'heroicon-s-trending-down')
            ->chart([17, 16, 15, 14, 15, 16, 17])
            ->color(Transaction::net() > 0 ? 'success' : 'danger'),
        ];    
    }
}
