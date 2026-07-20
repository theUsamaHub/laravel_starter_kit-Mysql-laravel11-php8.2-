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
                    <p class="lead text-muted">{{ __('We build solutions that scale.') }}</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <i class="bi bi-code-slash fs-1 text-primary mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Custom Development') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Tailored web applications built with modern technologies.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <i class="bi bi-cloud fs-1 text-success mb-3"></i>
                                <h5 class="fw-semibold">{{ __('Cloud Solutions') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Scalable infrastructure and deployment solutions.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <i class="bi bi-robot fs-1 text-warning mb-3"></i>
                                <h5 class="fw-semibold">{{ __('AI Integration') }}</h5>
                                <p class="text-muted" style="font-size: 0.875rem;">{{ __('Intelligent features powered by modern AI models.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
