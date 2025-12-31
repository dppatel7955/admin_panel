<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start',
        'end',
        'google_event_id', // ✅ ADD THIS
    ];

    protected $casts = [
        'start' => 'datetime',   // ✅ IMPORTANT
        'end'   => 'datetime',   // ✅ IMPORTANT
    ];
}
