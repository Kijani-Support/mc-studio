<?php

namespace App\Models;

use App\Traits\HasAuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Sgcomptech\FilamentTicketing\Interfaces\HasTickets;
use Sgcomptech\FilamentTicketing\Traits\InteractsWithTickets;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PurchaseOrder extends Model implements HasTickets
{
    use HasFactory, InteractsWithTickets, HasAuthUser;

    /**
     * @var string
     */
    
    protected $guarded = ['id']; 

    protected $table = 'purchase_orders';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'total_price',
        'status',
        'currency',
        'notes',
    ];

    // public function address(): MorphOne
    // {
    //     return $this->morphOne(OrderAddress::class, 'addressable');
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Override for model identifier on ticketing trait
     * 
     * @return string
     */
    public function model_name(): string
    {
        return 'number';
    }

}
