<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'excerpt', 'slug', 'content', 'image_url', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value || str_starts_with($value, 'http')) return $value;
                $awsUrl = env('AWS_URL');
                return $awsUrl ? rtrim($awsUrl, '/') . '/' . ltrim($value, '/') : $value;
            },
            set: function ($value) {
                $awsUrl = env('AWS_URL');
                if ($awsUrl && $value && str_starts_with($value, rtrim($awsUrl, '/'))) {
                    return str_replace(rtrim($awsUrl, '/') . '/', '', $value);
                }
                return $value;
            }
        );
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $awsUrl = env('AWS_URL');
                if ($awsUrl && $value) {
                    return str_replace('src="uploads/', 'src="' . rtrim($awsUrl, '/') . '/uploads/', $value);
                }
                return $value;
            },
            set: function ($value) {
                $awsUrl = env('AWS_URL');
                if ($awsUrl && $value) {
                    return str_replace(rtrim($awsUrl, '/') . '/', '', $value);
                }
                return $value;
            }
        );
    }

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
