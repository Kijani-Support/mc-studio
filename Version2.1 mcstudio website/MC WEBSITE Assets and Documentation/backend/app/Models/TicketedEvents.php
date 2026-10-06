<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class TicketedEvents extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSEO;

    protected $guarded = ['id']; 

    protected $table = 'ticketed_events';

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendees::class, 'ticketed_events_id');
    }
}
