<?php

namespace App\Api;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\SalesPrediction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Api\Exceptions\SalesPredictionError;

class Lisa {

  /**
   * Whether to retrieve entries from the Cache
   *
   * @var boolean
   */
  public static $USE_CACHE = true;

  public static $businessId;


  /**
   * Our Cache key namespace, ensuring no Cache collisions
   *
   * @var string
   */
  public static $CACHE_KEY = "lisa_api";

  public static function baseUrl()
  {
    $base_url = config('services.lisa.base_url');

    return $base_url;
  }

  protected static function generateUrl($url)
  {
    return self::baseUrl().$url;
  }

  protected static function getBusinessId()
  {
    self::$businessId = config('services.lisa.businessId');

    return self::$businessId;
  }

  protected static function getOptions($options = [])
  {
    if(app()->env === 'local'){
        $client_options = [
          'debug' => fopen('php://stderr', 'w'),
          'verifiy_host' => false,
        ];
      }else {
        $client_options = [
          'debug' => false,
          'verifiy_host' => true,
        ];
      }

      return array_merge($client_options, $options);
  }


  public function getRequest($url, $headers){

    try {

      $response = Http::withOptions(self::getOptions())->withHeaders($headers)->get($url)->throw();

      return $response;

    } catch (\Throwable $th) {
      logger('****** start of error in get request ******');
      logger('url of get request', [$url]);
      logger('error encountered in get request', [$th->getMessage()]);
      logger('****** end of error in get request ******');
      throw $th;
    }

  }

  public function postRequest($url, $data, $headers = [])
  {
    $request_headers = array_merge(['Accept' => 'application/json','Content-Type' => 'application/json'], $headers);

    try {
      $response = Http::withOptions(self::getOptions())->withHeaders($request_headers)->post($url, $data)->throw();

      return $response;

    } catch (\Throwable $th) {
      logger('****** start of error in post request ******');
      logger('url of the post request', [$url]);
      logger('error encountered in post request', [$th->getMessage()]);
      logger('****** end of error in post request ******');
      throw $th;
    }
  }

  public static function getToken()
  {

    $auth_token =  config('services.lisa.authToken');

    $dev_id = config('services.lisa.devId');
    $cache_key = self::$CACHE_KEY . ":token";

    $headers = [
      'Authorization' => "Bearer $auth_token"
    ];

    try {

      if (self::$USE_CACHE && Cache::has($cache_key)) {
        // Return cached token
        return Cache::get($cache_key);
      }else{

        if($dev_id){

          $response = (new self())->getRequest(self::generateUrl("/sandbox/open_api/v1/apps/$dev_id"), $headers);

          if($api_response = $response['APIresponse']){

            $keySecret = collect($api_response)
                            ->recursive()
                            ->map(function($item){
                                return [
                                  'key' => $item['consumer_key'],
                                  'secret' => $item['consumer_secret']
                                ];
                              });
            $expires =  ((int) $response['APIresponse'][0]['expiry_seconds'] - 30);

            $base64_key = base64_encode($keySecret->first()['key'] . $keySecret->first()['secret']);

            Cache::put($cache_key, $base64_key, now()->addSeconds($expires));

            return $base64_key;

          } else{
            logger('response does not have the APIresponse', [$response]);
          }

        }else{
          throw new Exception('Ensure a developer Id is set in the config');
        }
      }


    } catch (\Throwable $th) {
      logger('has Error'.$th->getMessage());
    }

  }


  public static function getAuthorizationToken()
  {
    $cache_key = self::$CACHE_KEY . ":auth_token";

    $authorization_url = self::generateUrl('/sandbox/open_api/v1/generate/lisa_client_credentials');

    $token = self::getToken();

    $headers = [
      "Authorization" => "Bearer $token"
    ];

    try {

      if (self::$USE_CACHE && Cache::has($cache_key))
      {
        // Return cached token
        return Cache::get($cache_key);

      }else{
        $response = (new self())->getRequest($authorization_url, $headers);

        if($response['success'] == true && $response['secure_access_token'])
        {
          $auth_token = $response['secure_access_token'];

          $expires =  ((int) $response['expires_in'] - 30);

          Cache::put($cache_key, $auth_token, now()->addSeconds($expires));

          return $auth_token;

        } else {
          throw new Exception("Unable to generate authorization token");
        }
      }

    } catch (\Throwable $th) {
      logger('has Error'.$th->getMessage());
      throw $th;
    }

  }


  public static function addProduct(Product $product)
  {

    $products_url = self::generateUrl('/sandbox/open_api/v1/add/catalogue');

    // $business_id = config('services.lisa.businessId');
    $business_id = self::getBusinessId();

    $token = self::getAuthorizationToken();

    $headers = [
      "Authorization" => "Bearer $token",
    ];

    $data = [
      "product_name"  => $product->name,
      "cost_price"    => $product->cost,
      "selling_price" => $product->price,
      "business_id"   => $business_id,
      "brand"         => $product->brand?->name, // should be required on filament side
      "quantity"      => $product->qty,
      "brand_type"    => $product->categories?->first()?->name ?? 'no category', // category
      "image"         => $product->media->first()?->getUrl() ?? asset('images/logo-header.png') //default to logo
    ];
    logger('data to send', [$data]);

    try {

      $response = (new self())->postRequest($products_url, $data, $headers);

      logger('Add product response', [$response]);
      return $response;

    } catch (\Throwable $th) {
      logger('error adding in product to lisa', [$th->getMessage()]);
      throw $th;
    }

  }

  public static function addOrder(Order $order)
  {
    $order_url = self::generateUrl('/sandbox/open_api/v1/create/order');

    $token = self::getAuthorizationToken();

    $business_id = self::getBusinessId();

    $headers = [
      "Authorization" => "Bearer $token",
    ];

    $data = [
      'seller_id' => 1,
      'price' => $order->order_total,
      'discount' => 0,
      'profit' => 0,
      'business_id' => $business_id,
      'payment_method' => $order->payment->payment_method,
      'transaction_type' => $order->payment->transaction_type,
      'phone' => $order->user->phone_number,
      'supplier_name' => '',
      'transaction_details' => [$order],
    ];

    try {

      $response = (new self())->postRequest($order_url, $data, $headers);

      logger('Add product response', [$response]);

      return $response;


    } catch (\Throwable $th) {
      logger('error adding in order to lisa', [$th->getMessage()]);
      throw $th;
    }


  }

  public static function getSalesPredictions()
  {
    $business_id = config('services.lisa.businessId');
    $sales_prediction_url = self::generateUrl('/sandbox/open_api/v1/predict/sales/' . $business_id);

    $token = self::getAuthorizationToken();

    $headers = [
      "Authorization" => "Bearer $token",
    ];

    try {

      $response = (new self())->getRequest($sales_prediction_url, $headers);

      if($response['success'] && $response['data']){

        SalesPrediction::create([
          'data' => $response['data']
        ]);

      }else {
        throw new SalesPredictionError("Error creating order");
      }

      logger('Get sales prediction response', [$response]);

    } catch (\Throwable $th) {
      logger('error getting sales predictions from lisa', [$th->getMessage()]);
      throw $th;
    }
  }

}
