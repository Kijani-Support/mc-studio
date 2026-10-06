<?php

namespace App\Filament\Resources\SmsTemplateResource\Pages;

use App\Filament\Resources\SmsTemplateResource;
use App\SmsPreview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSmsTemplate extends EditRecord
{
    protected static string $resource = SmsTemplateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('preview')
                ->action('')
                ->label('Preview')
                ->color('primary')
                ->slideOver()
                ->modalContent(SmsPreview::make($this->record))
//                ->modalSubmitAction(fn($action) => $action->hidden()),
        ];
    }
}
