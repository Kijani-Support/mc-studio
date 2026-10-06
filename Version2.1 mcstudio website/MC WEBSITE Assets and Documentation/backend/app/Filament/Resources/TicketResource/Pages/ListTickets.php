<?php

namespace App\Filament\Resources\TicketResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\HtmlString;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TicketResource;
use Illuminate\Contracts\Support\Htmlable;
use Sgcomptech\FilamentTicketing\Filament\Resources\TicketResource\Pages\ListTicket as BaseList;

class ListTickets extends BaseList
{

    public function getTableHeading(): Htmlable|null
    {
        return ($this->rec && $this->recid)
            ? new HtmlString(__('Support Tickets') . ' [<b><em>' .
                class_basename($this->recInstance->model_class())." #".
                $this->recInstance->{$this->recInstance->model_name()}
                . '</em></b>]')
            : null;
    }
}
