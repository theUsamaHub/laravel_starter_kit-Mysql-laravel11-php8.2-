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
                            {{ __('Built with Laravel 13, PHP 8.5+, Bootstrap 5, and following SOLID principles, this starter kit provides everything you need to build scalable applications from hackathons to enterprise systems.') }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-3"><i class="bi bi-check-circle text-primary me-2"></i>{{ __('What We Provide') }}</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Full authentication with email verification and password reset') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Role-based access control (RBAC) with granular permissions') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Admin panel with 17+ management modules') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Sanctum-powered REST API with versioning') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Scheduled content publishing and unpublishing') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-primary me-1"></i>{{ __('Database backup, log viewer, and health monitoring') }}</li>
                                    <li class="mb-0"><i class="bi bi-dot text-primary me-1"></i>{{ __('IP whitelisting, session management, and audit trails') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-3"><i class="bi bi-stack text-success me-2"></i>{{ __('Tech Stack') }}</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('Laravel 13 + PHP 8.5') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('Bootstrap 5 + Alpine.js + Vite') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('PostgreSQL / SQLite with 19 database tables') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('Sanctum API tokens and session-based auth') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('Database queue driver for background jobs') }}</li>
                                    <li class="mb-2"><i class="bi bi-dot text-success me-1"></i>{{ __('Polymorphic relationships for media, tags, and activity') }}</li>
                                    <li class="mb-0"><i class="bi bi-dot text-success me-1"></i>{{ __('Service layer architecture with reusable traits') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
