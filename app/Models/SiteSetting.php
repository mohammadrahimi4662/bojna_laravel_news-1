<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_type',
        'logo_text',
        'logo_image',
        'show_date_info',
        'footer_banner',
        'footer_about',
        'footer_social_links',
    ];

    protected $casts = [
        'footer_social_links' => 'array',
        'show_date_info' => 'boolean',
    ];
}
