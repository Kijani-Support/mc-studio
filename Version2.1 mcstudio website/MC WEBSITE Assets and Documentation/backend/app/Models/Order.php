<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Events\OrderCreated;
use App\Models\OrderReturn;
use App\Traits\HasAuthUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sgcomptech\FilamentTicketing\Interfaces\HasTickets;
use Sgcomptech\FilamentTicketing\Traits\InteractsWithTickets;

class Order extends Model implements HasTickets
{
    use HasFactory, SoftDeletes, InteractsWithTickets, HasAuthUser;

    protected $dispatchesEvents = [
        'created' => OrderCreated::class
    ];

    /**
     * @var string
     */
    
    protected $guarded = ['id']; 

    protected $table = 'orders';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'total_price',
        'order_tax',
        'status',
        'currency',
        'shipping_price',
        'shipping_method',
        'notes',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function address(): MorphOne
    {
        return $this->morphOne(OrderAddress::class, 'addressable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, OrderItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->latest();
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function returns()
    {
        return $this->hasMany(OrderReturn::class);
    }

    public function lisaDetails(): HasOne
    {
        return $this->hasOne(LisaOrderDetails::class);
    }

    public function grossTotal(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->total_price + $this->order_tax),
        );
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
