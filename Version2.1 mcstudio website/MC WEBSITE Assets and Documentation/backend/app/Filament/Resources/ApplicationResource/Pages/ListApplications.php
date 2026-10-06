<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use App\Filament\Resources\ApplicationResource;
use App\Exports\ApplicationExport;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export_csv')
                ->label('Export CSV')
                // ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    return Excel::download(new ApplicationExport(), 'applications.csv');
                }),
        ];
    }
}
