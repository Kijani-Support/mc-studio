<?php

namespace App\Enums;


enum OrderStatus: string{
  case New = 'new';

  case Processing = 'processing';

  case Shipped = 'shipped';

  case Delivered = 'delivered';

  case Canceled = 'canceled';

  public static function all(): array
  {
    return collect(self::cases())
            ->flatMap(function($item){
              return [ $item->name => $item->value];
            })
            ->toArray();
  }

  public function getLabel(): string
  {
    return match($this) {
      self::Processing => 'Processing',
      self::Shipped => 'Shipped',
      self::Delivered => 'Delivered', 
      self::Canceled => 'Canceled',
      self::New => 'New',
    };
  }

}