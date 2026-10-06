<?php

namespace App\Filament\Tables\Actions;

class TicketAction extends \Sgcomptech\FilamentTicketing\Tables\Actions\TicketAction
{
    public function setUp(): void
    {
        $this->label(__('Ticket'));

        $this->icon('heroicon-o-ticket');

        $this->url(fn ($record) => route('filament.resources.tickets.create', [
            'recid' => $record->id,
            'rec' => $record->model_class() ?? null,
        ]));
    }
}
