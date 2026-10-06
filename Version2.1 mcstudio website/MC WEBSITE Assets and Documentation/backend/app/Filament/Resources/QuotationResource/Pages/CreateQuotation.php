<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\QuotationResource;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function afterCreate(): void
    {
        $quote = $this->record;

        $itemTotals = $quote->items->sum(fn ($item): float => (float) ($item->unit_price * $item->qty));
        
        $quote->update([
            'total_price' => $itemTotals
        ]);

        Notification::make()
            ->title('New Quotation')
            ->icon('heroicon-o-shopping-bag')
            ->body("**You have received a new quote.**")
            ->actions([
                Action::make('View')
                    ->url(QuotationResource::getUrl('edit', ['record' => $quote])),
            ])
            ->sendToDatabase($quote->user);
            
            event( new SystemEvent($this->getModel()::find($this->record->id), 'create_quotation'));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
