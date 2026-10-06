<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BusinessSettings extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'business_settings';

        /**
     * @var string
     */
    
     protected $guarded = ['id']; 
}
