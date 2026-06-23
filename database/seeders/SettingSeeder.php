<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => ['value' => 'QRHub', 'type' => 'text'],
            'site_title' => ['value' => 'QRHub - Free Custom QR Code Generator with Logo', 'type' => 'text'],
            'site_description' => ['value' => 'Create custom QR codes with logos, colors, transparent backgrounds, and variable margins. Fast, secure, mobile responsive, and 100% free with no registration.', 'type' => 'textarea'],
            'site_keywords' => ['value' => 'qr code, qr code generator, custom qr code, free qr generator, qr code with logo, vector qr code, svg qr code', 'type' => 'text'],
            'google_analytics_id' => ['value' => '', 'type' => 'text'],
            'ad_header' => ['value' => '', 'type' => 'code'],
            'ad_content' => ['value' => '', 'type' => 'code'],
            'ad_sidebar' => ['value' => '', 'type' => 'code'],
            'ad_footer' => ['value' => '', 'type' => 'code'],
            'ad_sticky' => ['value' => '', 'type' => 'code'],
        ];

        foreach ($settings as $key => $data) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $data['value'], 'type' => $data['type']]
            );
        }
    }
}
