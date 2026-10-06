<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignItem extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'campaign_items';
}
