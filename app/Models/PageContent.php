<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $fillable = [
        'page_slug', 'section_key', 'version', 'order', 'title', 
        'subtitle', 'content', 'attributes', 'is_active'
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];
}
