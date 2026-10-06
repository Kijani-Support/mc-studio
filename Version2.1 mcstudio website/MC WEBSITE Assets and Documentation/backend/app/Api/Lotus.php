<?php

namespace App\Api;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class Lotus
{
    private $client;

    public function __construct()
    {
        $this->client = Http::lotus();
    }

    private function get(string $url, array $params = [], array $options = [])
    {
        $response = $this->client->withOptions($options)->get($url);

        $response->throwUnlessStatus(200);

        return $response->json();

    }

    private function post(string $url, array $data = [], $options = [])
    {
        $options['debug'] = fopen('php://stderr', 'w');

        $response = $this->client->withOptions($options)->post($url, $data);

        $response->throwUnlessStatus(200);

        return $response->json();

    }

    public function getCollections()
    {
        $response = $this->get('/collections/');
    }

    public function requestMoney($data)
    {
        $payload = [
            "amount"                => $data->amount,
            "contact_phone_number"  => $data->phone_number,
            "contact_name"          => $data->contact_name,
            "description"           => $data->description
        ];

        //return $this->post("/collections/", $payload);

        return ["data" =>  [
                    "transaction" =>  [
                          "id" => 559616,
                          "status" => "pending",
                          "created" => "2024-06-19T07:21:45.387252Z",
                          "contact" =>  [
                            "name" => "Joe Waithaka",
                            "phone_number" => "+254718487108",
                          ],
                          "transaction_method" => "mpesa",
                        ],
                    "success" => true,
                    "message" => "Payment request has been sent successfully!",
                    ]
                ];
    }

    public function getCollection($id)
    {
        $response = $this->get("/collections/$id");
    }

    public function getBanks()
    {
        $response = $this->get('/banks');
        return $response;
    }

    public function viewContacts()
    {
        $response = $this->get("/contacts");
    }

    public function createContact($data)
    {
        $response = $this->post("/contacts", $data);
    }

    public function viewContact($id)
    {
        $response = $this->get("/contacts/$id");
    }

    public function getPayments()
    {
        $response = $this->get("/payments");
    }

    public function sendMoney($data)
    {
        $response = $this->post("/payments", $data);
    }

    public function getPayment($id)
    {
        $response = $this->get("/payments/$id");
    }

    public function getBulkPayments()
    {
        $response = $this->get("/bulk_payments");
    }

    public function sendBulkPayment($data)
    {
        $response = $this->post("/bulk_payments", $data);
    }

    public function getBulkPayment($id)
    {
        $response = $this->get("/bulk_payments/$id");
    }

    public function getEmployees()
    {
        $response = $this->get("/employees");
    }

    public function getEmployee($id)
    {
        $response = $this->get("/employees/$id");
    }

    public function createOTP()
    {
        $response = $this->post("/otp");
    }

    public function getTransactionOTP()
    {
        $response = $this->get("/otp/get_transaction_otp/");
    }

    public function sendTransactionOTP()
    {
        $response = $this->get("/otp/send_transaction_otp/");
    }

    public function readOTP($id)
    {
        $response = $this->get("/otp/$id");
    }

}
