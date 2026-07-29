<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/" style="color: var(--bs-primary);">
            {{ config('app.name', 'LSK') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="publicNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="/">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}" href="{{ route('public.about') }}">{{ __('About') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.services') ? 'active' : '' }}" href="{{ route('public.services') }}">{{ __('Services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.pricing') ? 'active' : '' }}" href="{{ route('public.pricing') }}">{{ __('Pricing') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.contact') ? 'active' : '' }}" href="{{ route('public.contact') }}">{{ __('Contact') }}</a>
                </li>
            </ul>
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">{{ __('Dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">{{ __('Register') }}</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
