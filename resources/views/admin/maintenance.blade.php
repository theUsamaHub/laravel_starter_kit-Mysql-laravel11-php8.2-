<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('Maintenance Mode') }}</h2>
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Toggle Card -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-semibold mb-1">{{ __('Maintenance Mode') }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                {{ __('When enabled, only admin users can access the site. All other visitors will see the maintenance page.') }}
                            </p>
                        </div>
                        <form action="{{ route('admin.maintenance.toggle') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ $isMaintenance ? 'btn-danger' : 'btn-success' }} btn-lg px-4">
                                <i class="bi bi-{{ $isMaintenance ? 'power' : 'power' }} me-1"></i>
                                {{ $isMaintenance ? __('Disable') : __('Enable') }}
                            </button>
                        </form>
                    </div>

                    <div class="mt-3">
                        @if ($isMaintenance)
                            <div class="alert alert-warning d-flex align-items-center mb-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>{{ __('Maintenance mode is currently ENABLED') }}</strong> — {{ __('Only admin users can access the site.') }}
                            </div>
                        @else
                            <div class="alert alert-success d-flex align-items-center mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>{{ __('Maintenance mode is DISABLED') }}</strong> — {{ __('The site is accessible to all users.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Message Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Maintenance Message') }}</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.maintenance.message') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="message" class="form-label fw-medium">{{ __('Message shown to visitors') }}</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3" required>{{ old('message', $message) }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>{{ __('Save Message') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Info Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('How It Works') }}</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="bi bi-info-circle text-primary me-2 mt-1"></i>
                            <span style="font-size: 0.875rem;">{{ __('When enabled, a 503 maintenance page is shown to all visitors except admins.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="bi bi-shield-check text-success me-2 mt-1"></i>
                            <span style="font-size: 0.875rem;">{{ __('Admin users can still access the site normally to manage content.') }}</span>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="bi bi-broadcast text-warning me-2 mt-1"></i>
                            <span style="font-size: 0.875rem;">{{ __('The /up health check endpoint remains accessible for monitoring.') }}</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="bi bi-clock-history text-info me-2 mt-1"></i>
                            <span style="font-size: 0.875rem;">{{ __('Visitors on the 503 page can see your custom message and the page auto-refreshes.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
