<?php

namespace App\Api;

use Exception;
use Illuminate\Support\Str;
use App\Contracts\SmsInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\GuzzleException;

class Zettatel implements SmsInterface
{
    //url - "https://portal.zettatel.com/SMSApi/"
    private string $baseUrl;

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = Config::get('services.zettatel.apikey');
        $this->baseUrl = Config::get('services.zettatel.baseurl');
    }

    protected function buildUrl(string $endpoint, array $params = []): string
    {
        $url = $this->baseUrl . '/' . $endpoint;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    private function buildParams(array $params = []): array
    {
        $default_params = [
            'userid' => config('services.zettatel.userid'),
            'password' => config('services.zettatel.password'),
            'senderid' => config('services.zettatel.senderid'),
            'msgType' => 'text',
            'duplicatecheck' => 'true',
            'output' => 'json',
        ];

        return $default_params;
    }

    public function send($data, $headers = [])
    {
        $request_headers = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ], $headers);


        $payload = array_merge([
            'mobile'     => $this->formatNumber($data->mobile),
            'msg'        => $data->message,
            'sendMethod' => 'quick',
        ], $this->buildParams());

        $response = $this->post('send', $payload, $request_headers);

        return $response;

    }

    /**
     * @throws Exception
     */
    public function get($endpoint, array $params = [], array $options = []): mixed
    {
        $url = $this->buildUrl($endpoint, $params);

        return $this->sendRequest(method: 'GET', url: $url, options: $options);
    }

    /**
     * @throws Exception
     */
    public function post($endpoint, array $data = [], $options = []): mixed
    {
        $url = $this->buildUrl($endpoint);

        return $this->sendRequest(method: 'POST', url: $url, data: $data, options: $options);
    }

    protected function sendRequest(string $method, string $url, array $data = [], array $options = [])
    {
        $options = array_merge([
            'apikey' => $this->apiKey,
        ], $options);

        try {
            if ($method === 'POST') {
                $response = Http::withHeaders($options)
                                ->asForm()
                                ->post($url, $data);
                logger($response);
            }else{
                $response = Http::withUrlParameters($options)->get($url);
                logger($response);
            }

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            } else {
                throw new \Exception("API request failed with status code: " . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            throw new \Exception("Error sending request to third-party API: " . $e->getMessage());
        } catch (GuzzleException $e) {
            logger("Error sending guzzle request: ". $e->getMessage());
        }

    }

    private function formatNumber($number)
    {
        return Str::replaceFirst('0', '254', $number);
    }

}
