<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReturnItem extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    protected $table = 'stock_return_items';
}
