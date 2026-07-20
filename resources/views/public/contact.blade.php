<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Contact') }} - {{ config('app.name') }}</title>
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.public-navbar')

        <section class="py-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h1 class="fw-bold mb-4 text-center">{{ __('Contact Us') }}</h1>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <form>
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-medium">{{ __('Name') }}</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="message" class="form-label fw-medium">{{ __('Message') }}</label>
                                        <textarea class="form-control" id="message" rows="5" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Send Message') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.public-footer')
    </body>
</html>
