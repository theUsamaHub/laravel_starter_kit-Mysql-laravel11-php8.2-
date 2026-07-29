<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\ValidationRule;
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

        // Default validation rules
        $rules = [
            [
                'form_name' => 'contact_form',
                'rules' => [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255'],
                    'subject' => ['nullable', 'string', 'max:255'],
                    'message' => ['required', 'string', 'max:5000'],
                ],
                'custom_messages' => [
                    'name.required' => 'Please enter your name.',
                    'email.required' => 'Please enter your email address.',
                    'email.email' => 'Please enter a valid email address.',
                    'message.required' => 'Please enter your message.',
                ],
            ],
            [
                'form_name' => 'user_register',
                'rules' => [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ],
                'custom_messages' => null,
            ],
        ];

        foreach ($rules as $rule) {
            ValidationRule::updateOrCreate(
                ['form_name' => $rule['form_name']],
                $rule
            );
        }
    }
}
