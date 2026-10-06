<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProjectExpense extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

        /**
     * @var string
     */
    protected $guarded = ['id']; 

    protected $table = 'project_expenses';
}
