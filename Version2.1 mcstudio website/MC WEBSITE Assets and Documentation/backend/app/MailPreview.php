<?php

namespace App;

use App\Models\Product;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Support\Htmlable;

class MailPreview implements Htmlable
{

  protected $template;

  protected $record;

  protected $data;

  public function __construct(EmailTemplate $emailTemplate)
  {
    $this->record = $emailTemplate;
  }

  public static function make(EmailTemplate $template): self
  {
    return new self($template);
  }

  public function getRecordData(): ?array
  {
    $record_type = $this->record['record type'];

    switch($record_type){
      case 'create_customer':
          $this->template = 'user-welcome';
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'email'    => 'johndoe@kijani.co',
              'link'     => $this->prepareLink(),
              'template' => $this->record->body
          ];
          break;
      case 'create_supplier':
          $this->template = 'user-welcome';
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'email'    => 'johndoe@kijani.co',
              'link'     => $this->prepareLink(),
              'template' => $this->record->body
          ];
          break; 
      case 'create_quotation':
          $this->template = $record_type;
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'template' => $this->record->body,
              'quotation_items'  => $this->prepareItems('Quotation')['template'],
              'quotation_number' => $this->prepareItems('Quotation')['number'],
          ];
          break;
      case 'create_purchase_order':
          $this->template = $record_type;
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'template' => $this->record->body,
              'purchase_order_items'  => $this->prepareItems('PurchaseOrder')['template'],
              'purchase_order_number' => $this->prepareItems('PurchaseOrder')['number'],
          ];
          break;
      case 'create_order':
          $this->template = $record_type;
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'template' => $this->record->body,
              'order_items'  => $this->prepareItems('Order')['template'],
              'order_number' => $this->prepareItems('Order')['number'],
          ];
          break; 
      case 'create_stock_return':
          $this->template = $record_type;
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'template' => $this->record->body,
              'reason'   => 'Items are not as advertised',
              'return_items' => $this->prepareReturnItems('StockReturn')['template'],
              'order_number' => $this->prepareReturnItems('StockReturn')['number'],
          ];
          break;
      case 'create_order_return':
          $this->template = $record_type;
          $this->data = [
              'name'     => 'John Doe',
              'subject'  => $this->record->subject,
              'template' => $this->record->body,
              'reason'   => 'Items are not as advertised',
              'return_items' => $this->prepareReturnItems('OrderReturn')['template'],
              'order_number' => $this->prepareReturnItems('OrderReturn')['number'],
          ];
          break;
      default:
      $this->template = $record_type;
    }

    return [$this->template, $this->data];
  }

  public function toHtml()
  {
    $this->getRecordData();

    return view("emails.".$this->template, $this->data)->render();
  }

  public function getFields(): array
    {
        $fields = [];
        
        switch ($this->record['record type']) 
        {
            case 'create_customer':
                $fields = $this->getUserModelFields();
                break;
            case 'create_supplier':
                $fields = $this->getUserModelFields();
                break; 
            case 'create_quotation':
                $fields = $this->getQuotationFields();
                break;
            case 'create_purchase_order':
                $fields = $this->getPurchaseOrderFields();
                break;
            case 'create_order':
                $fields = $this->getOrderFields();
                break; 
            case 'create_stock_return':
                $fields = $this->getStockReturnFields();
                break;
            case 'create_order_return':
                $fields = $this->getOrderReturnFields();
                break;
            
            default:
                break;
        }
        
        return $fields;
    }

    private function getUserModelFields(): array
    {
        return ['name', 'email','link'];
    }

    private function getQuotationFields(): array
    {
        return ['name', 'quotation_number', 'quotation_items'];
    } 
    
    private function getPurchaseOrderFields(): array
    {
        return ['name', 'purchase_order_number', 'purchase_order_items'];
    }
    private function getOrderFields(): array
    {
        return ['name', 'order_number', 'order_items'];
    }    
    
    private function getStockReturnFields(): array
    {
        return ['name', 'order_number', 'reason', 'return_items'];
    }    
    
    private function getOrderReturnFields(): array
    {
        return ['name', 'order_number', 'reason', 'return_items'];
    }

    public function prepareLink(): mixed
    {
        $template = <<<EOL
        <div>
            <div class="py-4 my-4 text-center">
                <a href="#" style="background-color:rgb(59,130,246);" class="bg-blue-500 text-white text-sm uppercase py-4 px-2 rounded-lg">click here to sign in to account</a>
            </div>
            <div class="text-sm py-4 my-4">
             If you are having trouble clicking the button, copy and paste the following link in your browser 
             <p>Test Link</p>
            </div>
        </div>
        EOL;


        return $template;
    }

    public function prepareItems($class): mixed
    {
        $model = new ("App\\Models\\".$class);
        $quotation = $model::factory()->state(['currency' => 'USD'])->make();
        $quotation->items = Product::factory()
                    ->count(3)
                    ->make();

        $orderItems = $quotation->items;
        $formattedItems = $orderItems->map(function($item)use($quotation){
            
            return [
                'name' => $item->name,
                'qty'  => fake()->randomDigit(),
                'unit_price' => $item->cost,
                'currency' => $quotation->currency
            ];
        });

        
        $total = $formattedItems->sum(function($item){
            return $item['unit_price'] * $item['qty'];
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
                <td class="text-sm font-bold tracking-wider">{$money($total, $item['currency'], true)}<b></b></td>
            </tr>
            <!--end tr-->
            <tr>
                <th colspan="3"></th>
                <td class="text-sm font-bold"><b>Tax Rate</b></td>
                <td class="text-sm font-bold"><b>0</b></td>
            </tr>
            <!--end tr-->
            <tr class="text-white bg-gray-800">
                <th colspan="3"></th>
                <td class="text-sm font-bold"><b>Total</b></td>
                <td class="text-sm font-bold"><b>{$money($total, $item['currency'], true)}</b></td>
            </tr>
            <!--end tr-->

                </tbody>
            </table>
            EOL;

            $stitchedTemplate =  $templateHead.$templateBody.$templateTail;

            return [
                'number' => $quotation->number,
                'template' => $stitchedTemplate
            ];
    }

    public function prepareReturnItems($class): mixed
    {
        $model = new ("App\\Models\\".$class);
        
        if($class == 'StockReturn'){
            $quotation = $model::factory()->state([
                'currency' => 'USD',
                'user_id'  => 1,
                'purchase_order_id' => 1,
                'order_id' => 1,
            ])->make();
        }else{
            $quotation = $model::factory()->state([
                'currency' => 'USD',
                'customer_id' => 1,
                'order_id' => 1,
            ])->make();
        }

        $quotation->items = Product::factory()
                    ->count(3)
                    ->make();

        $formattedItems = $quotation->items->map(function($item)use($quotation){

            return [
                'name' => $item->name,
                'qty'  => fake()->randomDigit(),
                'unit_price' => $item->cost,
                'currency' => $quotation->currency
            ];
        });

        
        $total = $formattedItems->sum(function($item){
            return $item['unit_price'] * $item['qty'];
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
            
        return [
            'number' => $quotation->number,
            'template' => $stitchedTemplate,
        ];
    }
}