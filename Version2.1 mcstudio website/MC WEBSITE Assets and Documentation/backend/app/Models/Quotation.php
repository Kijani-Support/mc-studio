<?php

namespace App\Models;

use App\Traits\HasAuthUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sgcomptech\FilamentTicketing\Interfaces\HasTickets;
use Sgcomptech\FilamentTicketing\Traits\InteractsWithTickets;

class Quotation extends Model implements HasTickets
{
    use HasFactory, InteractsWithTickets, HasAuthUser;

    protected $guarded = ['id']; 

    protected $table = 'quotations';

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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
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
