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

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-medium">{{ __('Name') }}</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-medium">{{ __('Email') }}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="subject" class="form-label fw-medium">{{ __('Subject') }}</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}">
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="message" class="form-label fw-medium">{{ __('Message') }}</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
