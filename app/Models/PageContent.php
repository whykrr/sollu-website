<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PageContent extends Model
{
    protected $fillable = [
        'page_slug', 'section_key', 'version', 'order', 'title', 
        'subtitle', 'content', 'attributes', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function attributes(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $awsUrl = env('AWS_URL');
                if ($awsUrl && $value) {
                    $value = str_replace('"uploads/', '"' . rtrim($awsUrl, '/') . '/uploads/', $value);
                }
                return json_decode($value, true);
            },
            set: function ($value) {
                $awsUrl = env('AWS_URL');
                $json = is_array($value) ? json_encode($value) : $value;
                if ($awsUrl && $json) {
                    $json = str_replace(rtrim($awsUrl, '/') . '/', '', $json);
                }
                return $json;
            }
        );
    }
}
