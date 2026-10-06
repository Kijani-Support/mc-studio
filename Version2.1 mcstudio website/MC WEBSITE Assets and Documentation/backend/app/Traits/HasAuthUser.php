<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasAuthUser {

  public function scopeAuthUser(Builder $query): Builder
    {
        return $query->whereHas('user', function($q){
            return $q->where('id', auth()->user()->id);
        });
    }
}