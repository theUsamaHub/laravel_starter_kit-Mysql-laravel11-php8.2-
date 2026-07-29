<footer class="bg-white border-top py-4 mt-auto">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="text-muted" style="font-size: 0.875rem;">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                </span>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('public.about') }}" class="text-muted text-decoration-none me-3" style="font-size: 0.875rem;">{{ __('About') }}</a>
                <a href="{{ route('public.services') }}" class="text-muted text-decoration-none me-3" style="font-size: 0.875rem;">{{ __('Services') }}</a>
                <a href="{{ route('public.pricing') }}" class="text-muted text-decoration-none me-3" style="font-size: 0.875rem;">{{ __('Pricing') }}</a>
                <a href="{{ route('public.contact') }}" class="text-muted text-decoration-none" style="font-size: 0.875rem;">{{ __('Contact') }}</a>
            </div>
        </div>
    </div>
</footer>
