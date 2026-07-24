<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>500 - {{ config('app.name', 'Laravel Starter Kit') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <style>
            .error-page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fdfcfb 100%);
                color: #333;
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
                opacity: 0.15;
                color: #e74c3c;
                text-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
            .error-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                color: #e74c3c;
                opacity: 0.8;
            }
            .error-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                color: #1a1a2e;
            }
            .error-message {
                font-size: 1rem;
                color: #666;
                margin-bottom: 2rem;
            }
            .error-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: #e74c3c;
                color: #fff;
                text-decoration: none;
                border-radius: 0.5rem;
                font-weight: 500;
                transition: all 0.2s;
            }
            .error-btn:hover {
                background: #c0392b;
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(231,76,60,0.4);
            }
            .error-links {
                margin-top: 1.5rem;
                display: flex;
                gap: 1rem;
                justify-content: center;
            }
            .error-links a {
                color: #999;
                text-decoration: none;
                font-size: 0.875rem;
                transition: color 0.2s;
            }
            .error-links a:hover {
                color: #333;
            }
        </style>
    </head>
    <body>
        <div class="error-page">
            <div class="error-card">
                <div class="error-code">500</div>
                <div class="error-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h1 class="error-title">{{ __('Server Error') }}</h1>
                <p class="error-message">{{ __('Something went wrong on our end. Our team has been notified and is working to fix the issue. Please try again later.') }}</p>
                <a href="{{ url('/') }}" class="error-btn">
                    <i class="bi bi-house"></i> {{ __('Go Home') }}
                </a>
                <div class="error-links">
                    <a href="javascript:location.reload()">{{ __('Try Again') }}</a>
                    <a href="javascript:history.back()">{{ __('Go Back') }}</a>
                </div>
            </div>
        </div>
    </body>
</html>
