<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CustomerGroups extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 
    
    protected $table = 'customer_groups';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'customer_group_users', 'customer_group_id','user_id');
    }
}
