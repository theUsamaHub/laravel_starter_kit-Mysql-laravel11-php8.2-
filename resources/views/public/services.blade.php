<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Services') }} - {{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.public-navbar')

        <section class="py-5">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bold">{{ __('Our Services') }}</h1>
                    <p class="lead text-muted">{{ __('A complete Laravel starter platform.') }}</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Authentication & Security') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Complete auth system with registration, login, email verification, password reset, rate limiting, and RBAC.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-speedometer2 fs-1 text-success mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Admin Dashboard') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Analytics dashboard with stats widgets, activity charts, recent users, and quick actions for all management modules.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-tags fs-1 text-warning mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Content Management') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Categories with WYSIWYG editor, image upload, tags, soft deletes, recycle bin, and scheduled publishing.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-people fs-1 text-info mb-3"></i>
                                <h5 class="fw-semibold">{{ __('User & Role Management') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Manage users, assign roles, configure granular permissions per module — admin bypass included.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-hdd-stack fs-1 text-danger mb-3"></i>
                                <h5 class="fw-semibold">{{ __('API Platform') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Versioned REST API with Sanctum token auth, JSON resources, and full CRUD endpoints for categories and users.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-shield-lock fs-1 text-secondary mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Security & Monitoring') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('IP whitelist, session management, activity audit logs, maintenance mode, health dashboard, and database backups.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-bell fs-1 text-primary mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Notifications & Subscribers') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('In-app notification system with bell dropdown, contact form alerts, newsletter subscription management, and CSV export.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-gear fs-1 text-success mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Settings & Validation') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Database-backed settings, dynamic validation rules per form, custom error messages, and grouped configuration.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <i class="bi bi-journal-text fs-1 text-warning mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Logs & Backup') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Real-time log viewer, PostgreSQL database dumps, downloadable backups, and one-click log clearing.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
