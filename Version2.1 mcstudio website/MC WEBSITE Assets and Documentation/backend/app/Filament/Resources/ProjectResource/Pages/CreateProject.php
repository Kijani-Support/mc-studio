<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;


    protected $listeners = [
        'refresh' => 'refreshForm'
    ];
    public function refreshForm()
    {
        $this->record->save();
        $this->afterSave();
        $this->fillForm();
    }

    public function afterSave(): void
    {
        $project = $this->record;

        $expenses = $project->expenses->sum(function($item): float {
            return (float) ($item->unit_price * $item->qty);
        });

        $project->balance = ($project->budget - $expenses);
        $project->save();
    }
}
