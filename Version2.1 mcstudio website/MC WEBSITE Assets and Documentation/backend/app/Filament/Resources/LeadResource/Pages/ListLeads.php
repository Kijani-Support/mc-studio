<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Exports\LeadExport;
use Maatwebsite\Excel\Facades\Excel;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_csv')
                ->label('Export to CSV')
               // ->icon('heroicon-o-arrow-down')
                ->action(fn () => Excel::download(new LeadExport, 'leads.csv')),
        ];
    }
}
