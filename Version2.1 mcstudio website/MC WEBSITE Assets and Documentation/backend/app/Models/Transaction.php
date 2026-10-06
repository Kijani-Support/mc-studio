<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function purchase_order(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function scopeMethod(Builder $query, $type): Builder
    {
        return $query->where('method', $type);
    }
    public function scopeType(Builder $query, $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeIncome(Builder $query)
    {
        return $query->where('type', 'income')->sum('amount');
    }
    
    public function scopeExpenses(Builder $query)
    {
        return $query->where('type', 'expense')->sum('amount');
    }
    
    public static function net(): float
    {
        $income = self::where('type', 'income')->sum('amount');
        $expenses = self::where('type', 'expense')->sum('amount');

        return ($income - $expenses);
    }
}
