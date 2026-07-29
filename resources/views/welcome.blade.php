<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel Starter Kit') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.public-navbar')

        <!-- Hero Section -->
        <section class="py-5 bg-white">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold mb-3">
                            {{ __('Build something') }}
                            <span style="color: var(--bs-primary);">{{ __('amazing') }}</span>
                            {{ __('with Laravel Starter Kit') }}
                        </h1>
                        <p class="lead text-muted mb-4">
                            {{ __('A production-ready Laravel starter kit with Bootstrap 5, authentication, RBAC, API support, and a clean architecture that scales from hackathons to enterprise systems.') }}
                        </p>
                        <div class="d-flex gap-3">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">
                                    {{ __('Go to Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                    {{ __('Get Started') }}
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                                    {{ __('Learn More') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 text-center mt-5 mt-lg-0">
                        <div class="bg-light rounded-4 p-5">
                            <i class="bi bi-code-slash" style="font-size: 8rem; color: var(--bs-primary); opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">{{ __('Everything you need') }}</h2>
                    <p class="text-muted">{{ __('Built with best practices, ready for production.') }}</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-shield-check text-primary fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Authentication') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Secure login, registration, password reset, email verification, and RBAC built-in.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-hdd-stack text-success fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('API Ready') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Sanctum-powered API with versioning, resources, and token authentication.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-layers text-warning fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Clean Architecture') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Service layer, repository pattern, SOLID principles, and scalable folder structure.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-phone text-info fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Bootstrap 5') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Responsive, modern UI with Bootstrap 5, reusable components, and consistent design.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-gear text-danger fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('CRUD Blueprint') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Category module as a blueprint with search, pagination, soft deletes, and validation.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-secondary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-arrow-up-right text-secondary fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Scalable') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Evolves into any domain: HR, CRM, ERP, E-Commerce, Booking, and more.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="bg-primary bg-opacity-10 py-5">
            <div class="container text-center">
                <h4 class="fw-semibold mb-2">{{ __('Stay Updated') }}</h4>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">{{ __('Subscribe to our newsletter for the latest updates and news.') }}</p>
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @error('email', 'subscribe')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @enderror
                        @include('partials.newsletter-form')
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
