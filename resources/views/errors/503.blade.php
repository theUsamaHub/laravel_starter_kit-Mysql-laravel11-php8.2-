<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>503 - {{ config('app.name', 'Laravel Starter Kit') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
        <style>
            .error-page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
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
            .countdown {
                font-size: 0.875rem;
                opacity: 0.7;
                margin-top: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="error-page">
            <div class="error-card">
                <div class="error-code">503</div>
                <div class="error-icon">
                    <i class="bi bi-tools"></i>
                </div>
                <h1 class="error-title">{{ __('Under Maintenance') }}</h1>
                <p class="error-message">{{ $message ?? __('We are currently performing scheduled maintenance. We will be back shortly. Thank you for your patience.') }}</p>
                <a href="{{ url('/') }}" class="error-btn">
                    <i class="bi bi-arrow-clockwise"></i> {{ __('Try Again') }}
                </a>
                <div class="countdown" id="countdown"></div>
            </div>
        </div>
        <script>
            // Auto-refresh every 30 seconds
            let seconds = 30;
            const el = document.getElementById('countdown');
            const timer = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(timer);
                    location.reload();
                }
                el.textContent = 'Page refreshes in ' + seconds + 's';
            }, 1000);
        </script>
    </body>
</html>
