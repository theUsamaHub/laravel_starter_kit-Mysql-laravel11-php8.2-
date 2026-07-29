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
                    <h1 class="fw-bold">{{ __('Simple, Transparent Pricing') }}</h1>
                    <p class="lead text-muted">{{ __('Choose the plan that fits your needs. All plans include lifetime access.') }}</p>
                </div>

                <div class="row g-4 justify-content-center">
                    <!-- Basic -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-semibold text-muted mb-1">{{ __('Basic') }}</h5>
                                <div class="my-4">
                                    <span class="display-4 fw-bold">$49</span>
                                    <span class="text-muted">{{ __('one-time') }}</span>
                                </div>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Single project license') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('All features included') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('6 months of updates') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Basic email support') }}</li>
                                    <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i>{{ __('Priority support') }}</li>
                                    <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i>{{ __('Lifetime updates') }}</li>
                                </ul>
                                <a href="{{ route('public.contact') }}" class="btn btn-outline-primary w-100">{{ __('Get Started') }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Standard (Recommended) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm border-primary border-2">
                            <div class="card-header bg-primary text-white text-center py-2" style="font-size:0.8rem;letter-spacing:0.05em;">
                                {{ __('MOST POPULAR') }}
                            </div>
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-semibold text-muted mb-1">{{ __('Standard') }}</h5>
                                <div class="my-4">
                                    <span class="display-4 fw-bold">$99</span>
                                    <span class="text-muted">{{ __('one-time') }}</span>
                                </div>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Up to 3 projects') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('All features included') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('1 year of updates') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Priority email support') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Commercial use allowed') }}</li>
                                    <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i>{{ __('Lifetime updates') }}</li>
                                </ul>
                                <a href="{{ route('public.contact') }}" class="btn btn-primary w-100">{{ __('Get Started') }}</a>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-semibold text-muted mb-1">{{ __('Enterprise') }}</h5>
                                <div class="my-4">
                                    <span class="display-4 fw-bold">$249</span>
                                    <span class="text-muted">{{ __('one-time') }}</span>
                                </div>
                                <ul class="list-unstyled text-start mb-4">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Unlimited projects') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('All features included') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Lifetime updates') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('VIP priority support') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Commercial use allowed') }}</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>{{ __('Custom modifications') }}</li>
                                </ul>
                                <a href="{{ route('public.contact') }}" class="btn btn-outline-primary w-100">{{ __('Get Started') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <p class="text-muted mb-1">{{ __('All plans include full source code, documentation, and access to future updates.') }}</p>
                    <p class="text-muted">{{ __('Need a custom solution?') }} <a href="{{ route('public.contact') }}" class="text-primary text-decoration-none fw-medium">{{ __('Contact us') }}</a></p>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
