<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Default settings
        $settings = [
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Laravel Starter Kit', 'type' => 'text'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'A production-ready Laravel starter kit', 'type' => 'textarea'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => null, 'type' => 'image'],
            ['group' => 'general', 'key' => 'site_favicon', 'value' => null, 'type' => 'image'],
            ['group' => 'general', 'key' => 'contact_email', 'value' => 'hello@example.com', 'type' => 'text'],
            ['group' => 'general', 'key' => 'contact_phone', 'value' => '', 'type' => 'text'],
            ['group' => 'general', 'key' => 'contact_address', 'value' => '', 'type' => 'textarea'],
            ['group' => 'seo', 'key' => 'meta_title', 'value' => 'Laravel Starter Kit', 'type' => 'text'],
            ['group' => 'seo', 'key' => 'meta_description', 'value' => 'A production-ready Laravel starter kit with roles, API, and admin panel', 'type' => 'textarea'],
            ['group' => 'seo', 'key' => 'og_image', 'value' => null, 'type' => 'image'],
            ['group' => 'social', 'key' => 'facebook_url', 'value' => '', 'type' => 'text'],
            ['group' => 'social', 'key' => 'twitter_url', 'value' => '', 'type' => 'text'],
            ['group' => 'social', 'key' => 'linkedin_url', 'value' => '', 'type' => 'text'],
            ['group' => 'social', 'key' => 'github_url', 'value' => '', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Mail settings
        $mailSettings = [
            ['group' => 'mail', 'key' => 'mail_driver', 'value' => 'log', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_host', 'value' => '', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_port', 'value' => '587', 'type' => 'number'],
            ['group' => 'mail', 'key' => 'mail_username', 'value' => '', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_password', 'value' => '', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_encryption', 'value' => 'tls', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_from_address', 'value' => 'hello@example.com', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_from_name', 'value' => 'Laravel Starter Kit', 'type' => 'text'],
            ['group' => 'mail', 'key' => 'mail_additional_emails', 'value' => '[]', 'type' => 'json'],
        ];

        foreach ($mailSettings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
