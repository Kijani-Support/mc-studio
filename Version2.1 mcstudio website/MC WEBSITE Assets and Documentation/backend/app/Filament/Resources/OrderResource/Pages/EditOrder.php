<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Contracts\PaymentGatewayInterface;
use Redirect;
use App\Models\Product;
use App\Events\SystemEvent;
use App\Models\Transaction;
use Filament\Pages\Actions;
use App\Models\BusinessSettings;
use LaravelDaily\Invoices\Invoice;
use Filament\Resources\Pages\EditRecord;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use App\Filament\Resources\OrderResource;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Models\Shipping;
use Filament\Forms;
use Illuminate\Support\Facades\Http;
use Filament\Notifications\Notification;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;


    protected function getActions(): array
    {
        return [

            Actions\DeleteAction::make(),

            Actions\RestoreAction::make(),

            Actions\ForceDeleteAction::make(),

            Actions\Action::make('send_email')
                ->label('Send Email')
                ->color('danger')
                ->action('sendEmail'),

            Actions\Action::make('view_pdf')
                ->label('View PDF')
                ->color('success')
                ->action('viewPdf'),

            Actions\Action::make('request_payment')
                ->label('Request Payment')
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
                        ->numeric()
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
                    ->action('requestPayment')
                    // ->visible(function(): bool{
                    //     return authID() === $this->record->user->id && $this->record->status === 'new';
                    // }),
        ];
    }
    public function requestPayment(array $data)
    {
        $order = $this->record;
        $order['phone'] = $data['contact_phone_number'] ?? $order->user->phone_number;
        $order['name'] = $data['contact_name'] ?? $order->user->name;
        $order['description'] = $data['description'];

        $amount = $data['amount'] ?? $this->record->gross_total;

        // app()->make(PaymentGatewayInterface::class)->charge($order, $amount);

//          $response =
//          $jsonresponse = $response->json();
//          $successful = $jsonresponse['data']['success'];
//          if($successful){
//                Notification::make()->title('Payment Requested Successfully')->success()->send();
//          }
//          else{
//                Notification::make()->title('Payment Request Failed. Try again')->error()->send();
//          }

    }

    public function sendEmail(){
        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_order'));
    }

    public function viewPdf(){
            $order = $this->record;

            $user = $order->user;
            $business_settings = BusinessSettings::take(1)->first();
            //dd($business_settings->getMedia());
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
                'address' => $order->address->country ." , " .$order->address->city ." , " . $order->shipping_method,
                'custom_fields' => [
                    'order number' => $order->number,
                ],
            ]);


            $notes = [
                '',
            ];
            $notes = implode("<br>", $notes);
            $invoice = Invoice::make('INVOICE - ' . $order->number)
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
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.')
                ->taxRate($order->tax_rate)
                ->filename('pdfs/orders/'. trim($client->name) . '/' .$order->number.'-'. $customer->name)
                ->addItems($items)
                ->notes($notes)
                ->shipping($order->shipping_price ?? 0)
                ->logo(public_path('images/logo-header.png'))
                // You can additionally save generated invoice to configured disk
                ->save('public');

            $link = $invoice->url();
           // dd($invoice);
           // dd($link);
            // Then send email to party with link

            // And return invoice itself to browser or have a different view
           // $url = ($invoice->url());
           Redirect::away($link);
        }

        protected function afterSave(): void
        {
            $order = $this->record;
            $shipping_cost = Shipping::where('shipping_area', $order->shipping_method)->first()?->shipping_cost ?? 0;
            $itemTotals = $order->items->sum(fn ($item): float => (float) ($item->unit_price * $item->qty) + $shipping_cost);
            $itemTotals += $order->shipping_price;

            $tax_rate  = (BusinessSettings::first()?->tax_amount / 100) ?? 0;
            $order_tax = $tax_rate * $itemTotals;

            $order->update([
                'total_price' => $itemTotals,
                'shipping_price'=> $shipping_cost,
                'order_tax' => $order_tax,
            ]);

            logger('tax', [$order_tax]);
            logger('shipping', [$shipping_cost]);

            if($order->status == 'shipped'){
                Transaction::create([
                    'number'  => '',
                    'payment_reference'  => '',
                    'type'    => '',
                    'method'  => '',
                    'order_id'  => $order->id,
                    'amount'  => $order->total,
                    'currency'  => $order->currency
                ]);
            }
        }
}
