<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuotationCreatedNotification extends Notification
{
    use Queueable;

    public $quotation;

    public $template;

    /**
     * Create a new notification instance.
     */
    public function __construct($quotation, $template)
    {
        $this->quotation = $quotation;
        $this->template  = $template; 
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
                    ->view('emails.create_quotation', [
                        'name' => $this->quotation->user->name,
                        'template' => $mail_template->body,
                        'quotation_items'  => $this->prepareItems(),
                        'quotation_number' => $this->quotation->number,
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
        $orderItems = $this->quotation->items;
        $formattedItems = $orderItems->map(function($item){
            $product = Product::find($item->product_id);
            return [
                'name' => $product->name,
                'qty'  => $item->qty,
                'unit_price' => $item->unit_price,
                'currency' => $this->quotation->currency
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
            <tr class="">
                <td colspan="3"></td>
                <td class="text-sm font-bold">Sub Total</td>
                <td class="text-sm font-bold tracking-wider">{$money($this->quotation->total_price, $item['currency'], true)}<b></b></td>
            </tr>
            <!--end tr-->
            <tr>
                <th colspan="3"></th>
                <td class="text-sm font-bold"><b>Tax Rate</b></td>
                <td class="text-sm font-bold"><b>$1.50%</b></td>
            </tr>
            <!--end tr-->
            <tr class="text-white bg-gray-800">
                <th colspan="3"></th>
                <td class="text-sm font-bold"><b>Total</b></td>
                <td class="text-sm font-bold"><b>{$money($this->quotation->total_price, $item['currency'], true)}</b></td>
            </tr>
            <!--end tr-->

                </tbody>
            </table>
            EOL;

            $stitchedTemplate =  $templateHead.$templateBody.$templateTail;

            return $stitchedTemplate;
    }
}
