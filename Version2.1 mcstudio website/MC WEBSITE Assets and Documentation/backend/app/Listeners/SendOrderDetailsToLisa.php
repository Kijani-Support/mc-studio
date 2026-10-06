<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Api\Lisa;
use App\Models\LisaOrderDetails;

class SendOrderDetailsToLisa
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $order = $event->order;

        // send the order details to Lisa API
        $response = Lisa::addOrder($order);

        if($response['success'] == 'true')
        {
            LisaOrderDetails::create([
                'order_id' => $order->id,
                'data' => $response['jsonData']
            ]);
        }
        
    }
}
