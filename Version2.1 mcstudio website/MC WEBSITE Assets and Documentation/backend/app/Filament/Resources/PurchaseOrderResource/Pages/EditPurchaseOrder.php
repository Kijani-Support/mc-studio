<?php

namespace App\Filament\Resources\PurchaseOrderResource\Pages;

use App\Models\Product;
use App\Events\SystemEvent;
use App\Models\Transaction;
use Filament\Pages\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\PurchaseOrderResource;
use Filament\Forms;
use Illuminate\Support\Facades\Http;

class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function afterSave(): void
    {
        $record = $this->record;

        $itemTotals = $record->items->sum(fn ($item): float => (float) ($item->cost_price * $item->qty));
        
        $record->update([
            'total_price' => $itemTotals
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function getActions(): array
    {
        return [
            Actions\Action::make('send_purchase_order')
            ->label('Send Purchase Order')
            ->action('sendPurchaseOrder')
            ->color('success')
            ->visible( fn(): bool => auth()->user()->can('create purchase orders') && $this->record->status === 'new'),


            Actions\Action::make('mark_as_fulfilled')
            ->label('Mark As Fulfilled')
            ->action('markAsFulfilled')
            ->color('primary')
            ->visible(fn (): bool => auth()->user()->can('create purchase orders') && $this->record->status === 'processing'),
            
            Actions\Action::make('send_payment')
            ->label('Send Payment')
            ->color('success')
            ->form([
                Forms\Components\TextInput::make('contact_phone_number')
                ->numeric()
                ->columnSpan([
                    'md' => 2,
                ])
                ->label('Phone Number')
                ->required(),
                Forms\Components\TextInput::make('description')
                ->columnSpan([
                    'md' => 2,
                ])
                ->default(function(){
                    return $this->record->number;
                })
                ->disabled()
                ->required(),
                Forms\Components\TextInput::make('amount')
                ->columnSpan([
                    'md' => 2,
                ])
                ->required(),
                Forms\Components\TextInput::make('contact_name')
                ->default(
                    function(){
                        $order = $this->record;
                        $user = $order->user;
                        return $user->name;
                    }
                )
                ->columnSpan([
                    'md' => 2,
                ])
                ->required(),
            ])
            ->action('sendPayment'),
            Actions\DeleteAction::make(),
        ];
    }

    public function sendPayment(array $data){
        $url = config('services.lotus.baseurl') . '/collections/';
        $request_headers = array_merge(['Accept' => 'application/json','Content-Type' => 'application/json','Authorization' => 'Token '.config('services.lotus.apikey')]);
        $response = Http::withHeaders($request_headers)->post($url, $data);
        $jsonresponse = $response->json();
        $successful = $jsonresponse['data']['success'];
        if($successful){
              Notification::make()->title('Payment Sent Successfully')->success()->send();
        }
        else{
              Notification::make()->title('Payment Failed. Try again')->error()->send();
        }
      //   dd($response->json());
  }

    public function sendPurchaseOrder(): void
    {
        $pOrder = $this->record;
        $pOrder->user->notify(
            Notification::make()
                ->title('New Purchase order')
                ->icon('heroicon-o-shopping-bag')
                ->body("**You have received a new purchase order.**")
                ->actions([
                    Action::make('View')
                        ->url(static::$resource::getUrl('edit', ['record' => $pOrder]))
                ])
                ->toDatabase()
        );
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_purchase_order'));
    }
    

    public function markAsFulfilled(): void
    {
        $pOrder = $this->record;
        try {
            
            $items = $pOrder->items;
            $items->each(fn($item) => $this->updateStock($item));

            $pOrder->update([
                'status' => 'fulfilled'
            ]);

            $this->refreshFormData([
                'status',
            ]);

            $transaction = DB::table('transactions')->whereNotNull('created_at')->latest('created_at')->first();
            if($transaction){
            $newTransaction= ($transaction->id) +1;
            }
            else{
                $newTransaction= 1;
            }
            // create a transaction
            Transaction::create([
                'number'  => $newTransaction,
                'payment_reference'  => $pOrder->number,
                'type'    => 'expense',
                'method'  => 'bank',
                'purchase_order_id'  => $pOrder->id,
                'amount'  => $pOrder->total_price,
                'currency'  => $pOrder->currency
            ]);
            

            Notification::make()
                ->title('Purchase Order has been marked as fulfilled')
                ->icon('heroicon-o-x-circle')
                ->iconColor('success')
                ->send();

        } catch (\Throwable $th) {
            
            Notification::make()
                ->title('Error: could not mark as fulfilled')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();

            logger('Error marking purchase order as fulfilled', [$th->getMessage()]);
        }


        
    }

    protected function updateStock($item): void
    {
        if($product = Product::find($item->product_id))
        {            
            $product->increaseStock($item->qty);
            
        }else{
            throw new \Exception('could not find the product');
        }
    }
}
