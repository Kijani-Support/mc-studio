<?php

namespace App\Filament\Resources\PurchaseOrderResource\Pages;

use App\Models\User;
use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\PurchaseOrderResource;

class ViewPurchaseOrder extends ViewRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('accept_purchase_order')
                ->label('Accept')
                ->color('primary')
                ->action('acceptPurchaseOrder')
                ->visible(function(): bool{
                    return authID() === $this->record->user->id && $this->record->status === 'new';
                }),

            Actions\Action::make('reject_purchase_order')
                ->label('Decline')
                ->color('warning')
                ->action('rejectPurchaseOrder')
                ->visible(function(): bool{
                    return authID() === $this->record->user->id && $this->record->status === 'new';
                }),
        ];
    }

    public function acceptPurchaseOrder(): void
    {
        $pOrder = $this->record;

        $pOrder->update([
            'status' => 'processing'
        ]);

        $this->refreshFormData([
            'status',
        ]);

        Notification::make()
            ->title('You have accepted the purchase order')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();

        $admins = User::admins()->get();

        $admins->each( function($admin) use($pOrder){
            $admin->notify(
                Notification::make()
                    ->title("Purchase order {$pOrder->number} has been accepted")
                    ->icon('heroicon-o-shopping-bag')
                    ->body("** Supplier {$pOrder->user->name} has accepted the purchase order.**")
                    ->actions([
                        Action::make('View')
                            ->url(static::$resource::getUrl('edit', ['record' => $pOrder])),
                    ])
                    ->toDatabase()
            );
        });
    }

    public function rejectPurchaseOrder(): void
    {
        $pOrder = $this->record;

        $pOrder->update([
            'status' => 'cancelled'
        ]);

        $this->refreshFormData([
            'status',
        ]);

        Notification::make()
            ->title('You have declined the purchase order')
            ->icon('heroicon-o-x-circle')
            ->iconColor('warning')
            ->send();

        $admins = User::admins()->get();

        $admins->each( function($admin) use($pOrder){
            $admin->notify(
                Notification::make()
                    ->title("Purchase order {$pOrder->number} has been declined")
                    ->icon('heroicon-o-shopping-bag')
                    ->body("** Supplier {$pOrder->user->name} has declined the purchase order.**")
                    ->actions([
                        Action::make('View')
                            ->url(static::$resource::getUrl('edit', ['record' => $pOrder])),
                    ])
                    ->toDatabase()
            );
        });
    }
}