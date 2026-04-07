<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Bisnis F&B',
            'Tips Retail',
            'Keuangan',
            'Layanan Jasa',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
