<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Pricing') }} - {{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.public-navbar')

        <section class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bold">{{ __('One Price. Everything Included.') }}</h1>
                    <p class="lead text-muted">{{ __('Get the complete Laravel Starter Kit with every feature, no tiers or upgrades.') }}</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-semibold text-muted mb-1">{{ __('Laravel Starter Kit') }}</h5>
                                <div class="my-4">
                                    <span class="display-4 fw-bold">$99</span>
                                    <span class="text-muted">{{ __('one-time') }}</span>
                                </div>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Unlimited projects') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('All 17+ admin modules') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('RBAC & permission management') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('REST API with Sanctum auth') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Bootstrap 5 UI kit') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Full source code') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Lifetime updates') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Commercial use allowed') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Priority email support') }}</li>
                                </ul>
                                <a href="{{ route('public.contact') }}" class="btn btn-primary w-100">{{ __('Get All That') }}</a>
                            </div>
                        </div>
                        <p class="text-center text-muted mt-4 mb-0">{{ __('Need a custom solution or have questions?') }} <a href="{{ route('public.contact') }}" class="text-primary text-decoration-none fw-medium">{{ __('Contact us') }}</a></p>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
