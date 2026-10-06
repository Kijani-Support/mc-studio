<?php

namespace App\Models;

use App\Events\ProductCreated;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $dispatchesEvents = [
        'created' => ProductCreated::class
    ];
    /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'products';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'featured' => 'boolean',
        'is_visible' => 'boolean',
        'backorder' => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at' => 'date',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse_stock')->withPivot('qty');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function warehouse_stock(): HasMany
    {
        return $this->hasMany(WarehouseStock::class, 'product_id');
    }

    public function lisaId(): HasOne
    {
        return $this->hasOne(LisaProduct::class, 'kijani_id', 'id');
    }

    public function lisaProductId(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->lisaId?->lisa_id,
        );
    }

    // public function comments(): MorphMany
    // {
    //     return $this->morphMany(Comment::class, 'commentable');
    // }

    public function increaseStock($qty = 0)
    {
        $this->qty = ( (int) $this->qty + (int) $qty );
        $this->save();
        return $this;
    }

    public function decreaseStock($qty = 0)
    {
        $this->qty = ( (int) $this->qty - (int) $qty );
        $this->save();
        return $this;
    }
}
