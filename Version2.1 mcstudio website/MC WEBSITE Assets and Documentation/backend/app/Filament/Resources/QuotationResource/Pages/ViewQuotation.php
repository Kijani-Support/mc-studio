<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Models\User;
use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\QuotationResource;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('accept_quote')
                ->label('Accept')
                ->color('primary')
                ->action('acceptQuote')
                ->visible(function(): bool{
                    return authID() === $this->record->user->id && $this->record->status === 'new';
                }),
                
            Actions\Action::make('reject_quote')
                ->label('Decline')
                ->color('warning')
                ->action('rejectQuote')
                ->visible(function(): bool{
                    return authID() === $this->record->user->id && $this->record->status === 'new';
                }),
        ];
    }

    public function acceptQuote(): void
    {
        $quotation = $this->record;

        $quotation->update([
            'status' => 'processing'
        ]);

        $this->refreshFormData([
            'status',
        ]);

        Notification::make()
            ->title('You have accepted the quotation')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();

        $admins = User::admins()->get();

        $admins->each( function($admin) use($quotation){
            $admin->notify(
                Notification::make()
                    ->title("Quotation {$quotation->number} has been accepted")
                    ->icon('heroicon-o-shopping-bag')
                    ->body("** {$quotation->user->name} has accepted the quote.**")
                    ->actions([
                        Action::make('View')
                            ->url(QuotationResource::getUrl('edit', ['record' => $quotation])),
                    ])
                    ->toDatabase()
            );
        });
    }

    public function rejectQuote(): void
    {
        $quotation = $this->record;

        $quotation->update([
            'status' => 'cancelled'
        ]);

        $this->refreshFormData([
            'status',
        ]);

        Notification::make()
                ->title('You have declined the quotation')
                ->icon('heroicon-o-x-circle')
                ->iconColor('warning')
                ->send();

        $admins = User::admins()->get();

        $admins->each( function($admin) use($quotation){
            $admin->notify(
                Notification::make()
                    ->title("Quotation $quotation->number has been declined")
                    ->icon('heroicon-o-shopping-bag')
                    ->body("** {$quotation->user->name} has declined the quote.**")
                    ->actions([
                        Action::make('View')
                            ->url(QuotationResource::getUrl('edit', ['record' => $quotation])),
                    ])
                    ->toDatabase()
            );
        });
    }
}
