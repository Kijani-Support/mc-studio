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

class Campaign extends Model implements HasTickets
{

    use HasFactory, SoftDeletes, InteractsWithTickets;

    /**
     * @var string
     */
    
    protected $guarded = ['id']; 

    protected $table = 'campaigns';

    public function customergroup(): BelongsTo
    {
        return $this->belongsTo(CustomerGroups::class, 'customer_group_id');
    } 
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CampaignItem::class, 'campaign_id');
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
