<?php

namespace App\Listeners;

use App\Models\LisaProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Api\Lisa;

class SendProductDetailsToLisa
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
        $product = $event->product;

        // Send the product details to Lisa
        $response = Lisa::addProduct($product);

        if($response['success'] == 'true')
        {
            LisaProduct::create([
                'kijani_id' => $product->id,
                'lisa_id'   => $response['jsonData']['id']
            ]);
        }
    }
}
