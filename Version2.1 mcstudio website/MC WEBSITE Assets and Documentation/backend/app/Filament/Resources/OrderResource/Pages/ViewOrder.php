<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Events\SystemEvent;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('send_email')
                ->label('Send Email')
                ->action('sendMail'),
            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('update orders')),
        ];
    }


    public function sendMail(): void
    {
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_order'));
    }
}
