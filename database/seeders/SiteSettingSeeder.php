<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'portal_url', 'value' => 'https://app.sollupos.com', 'type' => 'url'],
            ['key' => 'wa_number', 'value' => '6281234567890', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'hello@sollupos.com', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            \App\Models\SiteSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
