<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use Redirect;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quotation;
use App\Events\SystemEvent;
use Filament\Pages\Actions;
use App\Models\BusinessSettings;
use LaravelDaily\Invoices\Invoice;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use App\Filament\Resources\OrderResource;
use Filament\Notifications\Actions\Action;
use App\Filament\Resources\QuotationResource;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function afterSave(): void
    {
        $quote = $this->record;

        $itemTotals = $quote->items->sum(fn ($item): float => (float) ($item->unit_price * $item->qty));
        
        $quote->update([
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
            Actions\Action::make('send_quote')
                ->label('Send Quote')
                ->action('sendQuote')
                ->color('success')
                ->visible( fn(): bool => auth()->user()->can('create quotations') && $this->record->status === 'new'),

            Actions\Action::make('to_order')
                ->label('Convert to Order')
                ->action('toOrder')
                ->visible(fn(): bool => $this->record->status === 'processing' && !$this->record->order()->exists() && auth()->user()->can('create quotations')),

            Actions\DeleteAction::make(),

            Actions\Action::make('view_pdf')
            ->label('View PDF')
            ->color('success')
            ->action('viewPdf'),
        ];
    }

    public function sendQuote(): void
    {
        $quotation = $this->record;
        $quotation->user->notify(
            Notification::make()
                ->title('Received a new quotation')
                ->body('')
                ->icon('heroicon-o-shopping-bag')
                ->actions([
                    Action::make('View')
                        ->url(QuotationResource::getUrl('edit', ['record' => $quotation]))
                ])
                ->toDatabase()
        );
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_quotation'));
    }

    public function toOrder(): void
    {
        $quotation = $this->record->load('items');

        [$status, $order] = $this->createOrderFromQuotation($quotation);

        if($status && $order){

            $admins = User::admins()->get();

            $usersToNotify = $admins->push($order->user);

            if($usersToNotify->count()) {
                $usersToNotify->each(function($user) use($quotation, $order){
                    $user->notify(
                        Notification::make()
                            ->title('Received new order from quotation')
                            ->body("Quotation No. {$quotation->number} has been converted to an order.")
                            ->icon('heroicon-o-shopping-bag')
                            ->actions([
                                   Action::make('View')
                                        ->url(OrderResource::getUrl('edit', ['record' => $order])),
                                ])
                            ->toDatabase()
                    );
                });
            }

            $quotation->update([
                'status' => 'converted'
            ]);

            $this->refreshFormData([
                'status',
            ]);
            
            $quotation->order()->save($order);
            $quotation->save();

        }
    }

    public function createOrderFromQuotation($quotation): mixed
    {
        $status = false;
        $order = null;

        try {
            $order = new Order([
                'number'         => 'OR-' . random_int(100000, 999999),
                'total_price'    => $quotation->total_price,
                'status'         => 'new',
                'currency'       => $quotation->currency,
                'shipping_price' => floatval(0),
                'shipping_method'=> '',
                'notes'          => ''
            ]);

            $order->user()->associate($quotation->user);

            $items =  $quotation->items->map(function($item){
                return [
                    'product_id' => $item->product_id,
                    'qty'        => $item->qty,
                    'unit_price' => $item->unit_price
                ];
            });

            $order->save();
            
            $order->items()->createMany($items);

           Notification::make() 
                ->title('Converted to order successfully')
                ->success()
                ->send();

            $status = true;

        } catch (\Throwable $th) {
            logger('could not create order from quotation', [$th->getMessage()]);

            Notification::make() 
                ->title('Failed to convert to order')
                ->danger()
                ->send();

            $status = false;
        }

        return [$status, $order];
    } 
    
    public function viewPdf(){
        $order = $this->record;
        $user = $order->user;
        $business_settings = BusinessSettings::take(1)->first();
        $order_items = [];
        //dd($business_settings->getMedia());
        foreach($order->items as $item){
              //dd($item);
              $product = Product::find($item->product_id);
              array_push($order_items,
                (new InvoiceItem())
                    ->title($product->name)
                    ->description($product->description)
                    ->pricePerUnit($item->unit_price)
                    ->quantity($item->qty)
                    ->discount(0));
             // dd($product);
            }
        $items = $order_items;
        $client = new Party([
            'name'          => $business_settings->name,
            'email'         => $business_settings->email,
            'country'=> $business_settings->country,
            'city'=> $business_settings->city,
            'code'=>$business_settings->pobox,
            'phone' => $business_settings->phone,
            'address' => $business_settings->address .' '.$business_settings->country.' '.$business_settings->city.' '.$business_settings->pobox ,
            'custom_fields' => [
               
            ],
        ]);

        $customer = new Party([
            'name'          => $user->name,
            'email'         => $user->email,
            'phone' => $user->phone_number,
            //'address' => $order->address->country ." , " .$order->address->city ." , " . $order->shipping_method,
            'custom_fields' => [
                'Quotation' => $order->number,
            ],
        ]);

     
        $notes = [
            '',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('QUOTATION')
            //->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            ->sequence((int)$order->number)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol(strtoupper($order->currency))
            ->currencyCode(strtoupper($order->currency))
            ->currencyFormat('{SYMBOL} {VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename('/pdfs/quotations/'. $client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('images/logo-header.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
       // $url = ($invoice->url());
       Redirect::away($link);
    }


}
