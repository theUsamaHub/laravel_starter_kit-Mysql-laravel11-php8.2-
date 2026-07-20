<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('About') }} - {{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.public-navbar')

        <section class="py-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="fw-bold mb-4">{{ __('About Us') }}</h1>
                        <p class="lead text-muted">
                            {{ __('Laravel Starter Kit is a production-ready foundation built to accelerate development of any web application.') }}
                        </p>
                        <p class="text-muted">
                            {{ __('Built with Laravel 13, PHP 8.3+, Bootstrap 5, and following SOLID principles, this starter kit provides everything you need to build scalable applications from hackathons to enterprise systems.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
