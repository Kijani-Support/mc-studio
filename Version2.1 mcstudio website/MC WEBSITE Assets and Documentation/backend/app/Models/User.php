<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Support\Str;
//use App\Traits\ListsTableColumns;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Gate;
use Parental\HasChildren;
 
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, HasChildren;

    public static function boot() {
        
        parent::boot();
        
        static::creating(function($model) {
            if( !$model->password ){
                $model->password = config('helpers.password_gen');
            }
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'changed_initial_password',
        'phone_number',
        'expires_at',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'changed_initial_password' => 'boolean',
    ];

    protected $childTypes = [
        'admin' => Admin::class,
    ];

    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }


    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'user_id');
    }

    public function canAccessFilament(): bool
    {
        return true;
    }
    public function customergroups(): BelongsToMany
    {
        return $this->belongsToMany(CustomerGroups::class, 'customer_group_users','user_id','customer_group_id');
    }

    public function scopeAdmins(Builder $query): Builder
    {
        return $query->whereHas('roles', function($q){
            $q->where('name', 'admin');
        });
    }

    public function scopeSuppliers(Builder $query): Builder
    {
        return $query->whereHas('roles', function($q){
            $q->where('name', 'supplier');
        });
    }
    
    public function scopeCustomers(Builder $query): Builder
    {
        return $query->whereHas('roles', function($q){
            $q->where('name', 'customer');
        });
    }

    protected function gate(): void
    {
        Gate::define('viewTelescope', function (User $user) {
            return in_array($user->email, [
                'admin@admin.com',
            ]);
        });
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    
}
