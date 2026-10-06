<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
         /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'shipping_costs';
}
