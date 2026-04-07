<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'excerpt', 'slug', 'content', 'image_url', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Scope: hanya artikel yang sudah dipublikasikan.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
