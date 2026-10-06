<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sgcomptech\FilamentTicketing\Interfaces\HasTickets;
use Sgcomptech\FilamentTicketing\Traits\InteractsWithTickets;

class Project extends Model implements HasMedia, HasTickets
{
    use HasFactory, InteractsWithTickets, InteractsWithMedia;

     /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'projects';

    public function expenses(): HasMany
    {
        return $this->hasMany(ProjectExpense::class, 'project_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
