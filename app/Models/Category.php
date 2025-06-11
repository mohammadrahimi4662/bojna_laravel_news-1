<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_keywords',
        'meta_description',

    ];

    public function news()
    {
        return $this->hasMany(\App\Models\News::class);
    }
}
