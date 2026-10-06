<?php

namespace App\Models;

use Parental\HasParent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends User
{
    use HasParent;

    protected $guard_name = "web";

    public function impersonate($user) {
        //...
    }

    public function isExpired(): bool
    {
        return $this->subscriptions->first()->expires_at && now()->gt($this->subscriptions->first()->expires_at);
    }

    // public function subscriptions(): HasMany
    // {
    //     return $this->hasMany(Subscription::class);
    // }
}