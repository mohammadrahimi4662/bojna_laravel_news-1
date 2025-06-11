<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyMedia extends Model
{
    protected $fillable = ['title', 'lead', 'media_path', 'media_type', 'status', 'published_at'];

    protected $casts = [
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];
}
