<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        try {
            $this->overrideMailConfig();
        } catch (\Exception $e) {
            // DB not ready yet (migrations not run), fall back to .env
        }
    }

    private function overrideMailConfig(): void
    {
        if (!app()->runningInConsole() && !app()->environment('testing')) {
            $driver = Setting::get('mail_driver');

            if ($driver && $driver !== 'log') {
                config([
                    'mail.default' => $driver,
                    'mail.mailers.smtp.host' => Setting::get('mail_host', config('mail.mailers.smtp.host')),
                    'mail.mailers.smtp.port' => Setting::get('mail_port', config('mail.mailers.smtp.port')),
                    'mail.mailers.smtp.username' => Setting::get('mail_username', config('mail.mailers.smtp.username')),
                    'mail.mailers.smtp.password' => Setting::get('mail_password', config('mail.mailers.smtp.password')),
                    'mail.mailers.smtp.encryption' => Setting::get('mail_encryption', config('mail.mailers.smtp.encryption')),
                    'mail.from.address' => Setting::get('mail_from_address', config('mail.from.address')),
                    'mail.from.name' => Setting::get('mail_from_name', config('mail.from.name')),
                ]);
            }
        }
    }
}
