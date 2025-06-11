<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content', 'response', 'published_at', 'status'];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];
}
