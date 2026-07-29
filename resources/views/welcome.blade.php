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
                    <p class="text-muted">{{ __('17+ admin modules, REST API, RBAC, and production-ready tooling.') }}</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-speedometer2 text-primary fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Admin Dashboard') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Analytics with stats widgets, 7-day charts, activity summary, recent users, and quick action buttons.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-tags text-success fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Content & Categories') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('WYSIWYG editor, image uploads, tags, soft deletes, recycle bin, and scheduled publishing with cron.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-shield-check text-warning fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('RBAC & Permissions') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Multi-role system with auto-discovered module permissions, admin bypass, and per-action access control.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-hdd-stack text-info fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('REST API') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Versioned API via Sanctum with token auth, JSON resources, and full CRUD for categories and users.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-shield-lock text-danger fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Security & Monitoring') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('IP whitelist (CIDR/wildcard), session manager, activity audit logs, health dashboard, and maintenance mode.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="bg-secondary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                                    <i class="bi bi-bell text-secondary fs-4"></i>
                                </div>
                                <h5 class="fw-semibold">{{ __('Notifications & Alerts') }}</h5>
                                <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('In-app notification bell with dropdown, contact form alerts, newsletter subscribers, and CSV export.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- More Features -->
        <section class="py-5 bg-white">
            <div class="container py-3">
                <div class="text-center mb-5">
                    <h3 class="fw-bold">{{ __('And much more') }}</h3>
                    <p class="text-muted">{{ __('Every module is self-contained and production-ready.') }}</p>
                </div>
                <div class="row g-3 justify-content-center">
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-people text-primary"></i>
                            <span style="font-size: 0.875rem;">{{ __('User management') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-bookmark text-success"></i>
                            <span style="font-size: 0.875rem;">{{ __('Tag management') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-folder text-warning"></i>
                            <span style="font-size: 0.875rem;">{{ __('Media library') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-info"></i>
                            <span style="font-size: 0.875rem;">{{ __('Contact inbox') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-shaded text-danger"></i>
                            <span style="font-size: 0.875rem;">{{ __('Validation rules') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-gear text-secondary"></i>
                            <span style="font-size: 0.875rem;">{{ __('DB settings') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-primary"></i>
                            <span style="font-size: 0.875rem;">{{ __('Activity logs') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-badge text-success"></i>
                            <span style="font-size: 0.875rem;">{{ __('Session manager') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-database text-warning"></i>
                            <span style="font-size: 0.875rem;">{{ __('DB backups') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-journal-text text-info"></i>
                            <span style="font-size: 0.875rem;">{{ __('Log viewer') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-heart-pulse text-danger"></i>
                            <span style="font-size: 0.875rem;">{{ __('Health checks') }}</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-exclamation text-secondary"></i>
                            <span style="font-size: 0.875rem;">{{ __('Maintenance mode') }}</span>
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
