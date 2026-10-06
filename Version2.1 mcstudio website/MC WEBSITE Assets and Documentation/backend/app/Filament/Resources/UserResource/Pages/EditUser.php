<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Notifications\PasswordResetNotification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('send_link')
                ->label('Send Password Reset')
                ->action('sendPwReset')
                ->color('success')
                ->requiresConfirmation()
                ->visible( auth()->user()->can('create users')),
            Actions\DeleteAction::make(),
        ];
    }

    public function sendPwReset():void
    {
        $this->record->notify(new PasswordResetNotification($this->record));
        
        Notification::make() 
            ->title('Sent password reset successfully')
            ->success()
            ->send(); 
    }
}
