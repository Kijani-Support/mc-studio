<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TypeOverview extends BaseWidget
{
    // protected static string $view = 'filament.resources.transaction-resource.widgets.expenses-overview';

    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        return [
            Card::make('Cash', Transaction::method('cash')->get()->sum('amount')),

            Card::make('Mpesa', Transaction::method('mpesa')->get()->sum('amount')),

            Card::make('Bank', Transaction::method('bank')->get()->sum('amount')),
        ];    
    }
}
