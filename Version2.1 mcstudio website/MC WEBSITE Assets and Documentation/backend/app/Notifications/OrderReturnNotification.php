<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderReturnNotification extends Notification
{
    use Queueable;

    public $orderReturn;

    public $template;
    /**
     * Create a new notification instance.
     */
    public function __construct($orderReturn, $template)
    {
        $this->orderReturn = $orderReturn;
        $this->template    = $template;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail_template = EmailTemplate::where('record type', $this->template)->first();
        

        return (new MailMessage)
                    ->subject($mail_template->subject)
                    ->view('emails.create_order_return', [
                        'name' => $this->orderReturn->user->name,
                        'template' => $mail_template->body,
                        'reason' => $this->orderReturn->reason,
                        'return_items'  => $this->prepareItems(),
                        'order_number' => $this->orderReturn->order->number,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function prepareItems(): mixed
    {
        $orderItems = $this->orderReturn->items;
        $formattedItems = $orderItems->map(function($item){
            $product = Product::find($item->product_id);
            return [
                'name' => $product->name,
                'qty'  => $item->qty,
                'unit_price' => $item->unit_price,
                'currency' => $this->orderReturn->currency
            ];
        });

        $templateHead = <<<EOL
        <table class="table-auto py-10 mt-8 w-full lg:w-1/2">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-xs text-gray-500 ">
                        #
                    </th>
                    <th class="px-4 py-2 text-xs text-gray-500 ">
                        Product Name
                    </th>
                    <th class="px-4 py-2 text-xs text-gray-500 ">
                        Quantity
                    </th>
                    <th class="px-4 py-2 text-xs text-gray-500 ">
                        Rate
                    </th>
                    <th class="px-4 py-2 text-xs text-gray-500 ">
                        Subtotal
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
        EOL;


            $templateBody = "";
            $money = "money";
            $indexer = function($value){ return $value + 1; };

            foreach($formattedItems as $key => $item){
                $templateBody .= <<<EOL
                <tr class="whitespace-nowrap">
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {$indexer($key)}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {$item['name']}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500">{$item['qty']}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {$money($item['unit_price'], $item['currency'], true)}
                    </td>
                    <td class="px-6 py-4">
                    {$money(($item['unit_price'] * $item['qty'] ), $item['currency'], true)}
                    </td>
                </tr>
                EOL;
            }


            $templateTail = <<<EOL
                </tbody>
            </table>
            EOL;

            $stitchedTemplate =  $templateHead.$templateBody.$templateTail;

            return $stitchedTemplate;
    }
}
