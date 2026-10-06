<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTask extends Model
{
    use HasFactory;

            /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'project_tasks';

    protected $casts = [
        'due_date' => 'datetime',
        'started_at' => 'datetime',
    ];

    protected $with = ['project'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
