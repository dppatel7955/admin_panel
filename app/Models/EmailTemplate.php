<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'key',
        'theme',
        'name',
        'subject',
        'body',
        'is_active',
    ];
}
