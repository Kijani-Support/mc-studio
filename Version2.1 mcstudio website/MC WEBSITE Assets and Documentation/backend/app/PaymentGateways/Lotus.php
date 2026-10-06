<?php

namespace App\PaymentGateways;

use App\Api\Lotus as LotusClient;
use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;

class Lotus implements PaymentGatewayInterface
{
    private $client;

    public function __construct(LotusClient $client)
    {
        $this->client = $client;
    }

    public function charge(Order $order, $amount)
	{
        $data = (object)[
            'amount' => $amount,
            'phone_number' => $order->phone,
            'contact_name' => $order->name,
            'description' => "Payment for Order {$order->description}",
        ];

        dd($data);
		$response = $this->client->requestMoney($data);

        $this->processPayment($response);
	}

	public function processPayment($response)
	{
        $transaction = $response['data']['transaction'];


		// TODO: Implement processPayment() method.
	}

	public function verifyPayment($transaction)
	{
		// TODO: Implement verifyPayment() method.
	}
}
