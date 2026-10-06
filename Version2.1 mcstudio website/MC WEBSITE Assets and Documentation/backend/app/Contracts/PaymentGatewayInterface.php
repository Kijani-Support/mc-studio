<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function charge(Order $order, $amount);

    public function processPayment($payment);

    public function verifyPayment($transaction);
}
