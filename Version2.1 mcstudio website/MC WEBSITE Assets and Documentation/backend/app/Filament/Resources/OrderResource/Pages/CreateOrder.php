<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Product;
use App\Models\Shipping;
use App\Events\SystemEvent;
use App\Models\BusinessSettings;
use LaravelDaily\Invoices\Invoice;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use LaravelDaily\Invoices\Classes\Party;
use App\Filament\Resources\OrderResource;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;

class CreateOrder extends CreateRecord
{
    use HasWizard;

    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['shipping_method'] = Shipping::find($data['shipping_method'])->shipping_area;
       
        return $data;
    }

    protected function afterCreate(): void
    {
        $order = $this->record;

        $itemTotals = $order->items->sum(fn ($item): float => (float) ($item->unit_price * $item->qty));
        $itemTotals += $order->shipping_price;

        $tax_rate  = (BusinessSettings::first()?->tax_amount / 100) ?? 0;
        $order_tax = $tax_rate * $itemTotals;
        
        $order->update([
            'total_price' => $itemTotals,
            'order_tax' => $order_tax,
            'tax_rate' => $tax_rate,
        ]);

        Notification::make()
            ->title('New order')
            ->icon('heroicon-o-shopping-bag')
            ->body("**{$order->user->name} ordered {$order->items->count()} products.**")
            ->actions([
                Action::make('View')
                    ->url(OrderResource::getUrl('edit', ['record' => $order])),
            ])
            ->sendToDatabase(auth()->user());

        $this->generatePDF();

        event( new SystemEvent($this->getModel()::find($this->record->id), 'create_order'));
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Order Details')
                ->schema([
                    Card::make(OrderResource::getFormSchema())->columns(),
                ]),

            Step::make('Order Items')
                ->schema([
                    Card::make(OrderResource::getFormSchema('items')),
                ]),
        ];
    }

    protected function generatePDF(): void
    {
        $order = $this->record;
        $user = $order->user;
        $business_settings = BusinessSettings::take(1)->first();
        $order_items = [];
        
        foreach($order->items as $item){
            $product = Product::find($item->product_id);

            array_push($order_items,
              (new InvoiceItem())
                  ->title($product->name)
                  ->description($product->description)
                  ->pricePerUnit($item->unit_price)
                  ->quantity($item->qty)
                  ->discount(0));
        }

        $items = $order_items;
        $client = new Party([
            'name'          => $business_settings->name,
            'email'         => $business_settings->email,
            'custom_fields' => [
                'phone' => $business_settings->phone,
                'address' => $business_settings->address .' '.$business_settings->country.' '.$business_settings->city.' '.$business_settings->pobox ,
            ],
        ]);

        $customer = new Party([
            'name'          => $user->name,
            'custom_fields' => [
                'email'        => $user->email,
                'order number' => $order->number,
            ],
        ]);

        
        $notes = [
            '',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('INVOICE')
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
            ->filename('pdfs/orders/'. $client->name . '/' .$order->number.'-'. $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('images/logo-header.png'))
            // You can additionally save generated invoice to configured disk
            ->save('private');
    }
}
