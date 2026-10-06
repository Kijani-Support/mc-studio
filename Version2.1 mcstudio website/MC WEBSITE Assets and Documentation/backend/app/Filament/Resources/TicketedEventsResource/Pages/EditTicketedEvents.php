<?php

namespace App\Filament\Resources\TicketedEventsResource\Pages;

use App\Filament\Resources\TicketedEventsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicketedEvents extends EditRecord
{
    protected static string $resource = TicketedEventsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
