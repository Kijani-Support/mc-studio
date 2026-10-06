<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'data'
    ];

    public $casts = [
        'data' => 'array'
    ];
}
