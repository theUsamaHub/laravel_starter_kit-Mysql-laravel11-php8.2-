<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>419 - {{ config('app.name', 'Laravel Starter Kit') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <style>
            .error-page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                color: #fff;
            }
            .error-card {
                text-align: center;
                padding: 3rem;
                max-width: 480px;
            }
            .error-code {
                font-size: 8rem;
                font-weight: 800;
                line-height: 1;
                opacity: 0.2;
                text-shadow: 0 4px 20px rgba(0,0,0,0.2);
            }
            .error-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                opacity: 0.8;
            }
            .error-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .error-message {
                font-size: 1rem;
                opacity: 0.8;
                margin-bottom: 2rem;
            }
            .error-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: rgba(255,255,255,0.2);
                color: #fff;
                text-decoration: none;
                border-radius: 0.5rem;
                font-weight: 500;
                transition: all 0.2s;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.3);
            }
            .error-btn:hover {
                background: rgba(255,255,255,0.3);
                color: #fff;
                transform: translateY(-2px);
            }
            .error-links {
                margin-top: 1.5rem;
                display: flex;
                gap: 1rem;
                justify-content: center;
            }
            .error-links a {
                color: rgba(255,255,255,0.7);
                text-decoration: none;
                font-size: 0.875rem;
                transition: color 0.2s;
            }
            .error-links a:hover {
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="error-page">
            <div class="error-card">
                <div class="error-code">419</div>
                <div class="error-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h1 class="error-title">{{ __('Page Expired') }}</h1>
                <p class="error-message">{{ __('This page has expired due to inactivity. Please refresh and try again.') }}</p>
                <a href="{{ url('/') }}" class="error-btn">
                    <i class="bi bi-arrow-clockwise"></i> {{ __('Refresh') }}
                </a>
                <div class="error-links">
                    <a href="javascript:location.reload()">{{ __('Refresh Page') }}</a>
                </div>
            </div>
        </div>
    </body>
</html>
