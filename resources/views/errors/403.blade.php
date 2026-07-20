<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>403 - {{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="text-center">
            <div class="display-1 fw-bold text-muted">403</div>
            <h2 class="mb-3">{{ __('Access Denied') }}</h2>
            <p class="text-muted mb-4">{{ __('You do not have permission to access this page.') }}</p>
            <a href="/" class="btn btn-primary">{{ __('Go Home') }}</a>
        </div>
    </body>
</html>
