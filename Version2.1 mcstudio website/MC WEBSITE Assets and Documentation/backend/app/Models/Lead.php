<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'education',
        'experience',
        'current_role',
        'company',
        'languages', // store as JSON
        'cloud_platforms', // store as JSON
        'ai_experience',
        'availability',
        'motivation',
        'specialization',
        'additional_info',
        'laptop_access',
        'internet_quality',
    ];
}
