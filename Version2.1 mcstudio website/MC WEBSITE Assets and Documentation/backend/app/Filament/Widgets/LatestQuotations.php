<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Squire\Models\Currency;

class LatestQuotations extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 7;

    protected static ?string $pollingInterval = null;

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 5;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableQuery(): Builder
    {
        return QuotationResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Quotation Date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('number')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('user.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'danger' => 'cancelled',
                    'warning' => 'processing',
                    'success' => fn ($state) => in_array($state, ['converted', 'new']),
                ]),
            Tables\Columns\TextColumn::make('currency')
                ->getStateUsing(fn ($record): ?string => Currency::find($record->currency)?->name ?? null)
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('total_price')
                ->getStateUsing(function (Quotation $record){
                    $total = $record->items->sum(function($item): float {
                        return (float) ($item->unit_price * $item->qty);
                    });
                    return money($total, $record->currency, true);
                })
                ->searchable()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('open')
                ->url(fn (Quotation $record): string => QuotationResource::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole(['Admin', 'Customer']);
    }
}
