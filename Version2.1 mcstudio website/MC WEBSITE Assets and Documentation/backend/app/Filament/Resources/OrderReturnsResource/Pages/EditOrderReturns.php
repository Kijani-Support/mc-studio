<?php

namespace App\Filament\Resources\OrderReturnsResource\Pages;

use App\Filament\Resources\OrderReturnsResource;
use Filament\Forms;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderReturns extends EditRecord
{
    protected static string $resource = OrderReturnsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('settleReturn')
                ->action(
                    function( array $data){
                        
                    }
                )
                ->form([
                    Forms\Components\Select::make('action')
                    ->options([
                        'accept' => 'Accept',
                        'reject' => 'Reject'
                    ])
                ]),
            Actions\DeleteAction::make(),
        ];
    }
}
