<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SeoSetting extends Model
{
    protected $fillable = ['page_slug', 'meta_title', 'meta_description', 'og_image_url'];

    protected function ogImageUrl(): Attribute
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
}
