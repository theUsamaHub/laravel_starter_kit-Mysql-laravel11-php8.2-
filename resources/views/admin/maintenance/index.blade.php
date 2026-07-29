<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('Maintenance Mode') }}</h2>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3">
        <!-- Toggle -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Status') }}</h6></div>
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        @if ($isMaintenance)
                            <span class="badge bg-danger fs-6 px-3 py-2">{{ __('Maintenance mode is currently ENABLED') }}</span>
                            <p class="text-muted mt-2 mb-0">{{ __('Only admin users can access the site. All other visitors will see the maintenance page.') }}</p>
                        @else
                            <span class="badge bg-success fs-6 px-3 py-2">{{ __('Maintenance mode is DISABLED') }}</span>
                            <p class="text-muted mt-2 mb-0">{{ __('The site is accessible to all users.') }}</p>
                        @endif
                    </div>
                    <form action="{{ route('admin.maintenance.toggle') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg px-4 {{ $isMaintenance ? 'btn-success' : 'btn-danger' }}">
                            <i class="bi bi-{{ $isMaintenance ? 'check-circle' : 'exclamation-triangle' }} me-1"></i>
                            {{ $isMaintenance ? __('Disable Maintenance Mode') : __('Enable Maintenance Mode') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Message -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Maintenance Message') }}</h6></div>
                <div class="card-body">
                    <form action="{{ route('admin.maintenance.message') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="3">{{ old('message', $message) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check me-1"></i>{{ __('Update Message') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bypass Routes -->
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Bypass Routes') }}</h6></div>
                <div class="card-body">
                    <p class="text-muted small">{{ __('Comma-separated URI patterns that bypass maintenance mode. Uses Laravel request->is() pattern matching. Examples: login, register, forgot-password, reset-password*, admin/*.') }}</p>
                    <form action="{{ route('admin.maintenance.bypass-routes') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="text" name="bypass_routes" class="form-control" value="{{ old('bypass_routes', $bypassRoutes) }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check me-1"></i>{{ __('Update Bypass Routes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
