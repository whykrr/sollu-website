<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'portal_url', 'value' => 'https://app.sollu.local/login', 'type' => 'url'],
            ['key' => 'cta_trial_url', 'value' => 'https://app.sollu.local/trial', 'type' => 'url'],
            ['key' => 'wa_number', 'value' => '6281112345678', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'hello@sollu.local', 'type' => 'text'],
            ['key' => 'office_address', 'value' => "Gedung Sollu POS, Lt. 3\nJl. Sudirman No 123\nJakarta Selatan, 12190", 'type' => 'textarea'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/sollu', 'type' => 'url'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/sollu', 'type' => 'url'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/sollu', 'type' => 'url'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
