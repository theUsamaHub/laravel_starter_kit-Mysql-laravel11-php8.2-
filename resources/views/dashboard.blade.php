<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-person-check text-primary fs-4"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ __("You're logged in!") }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.875rem;">{{ __('Welcome back,') }} {{ Auth::user()->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-tags text-success"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Categories') }}</div>
                            <div class="fs-5 fw-semibold">--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-people text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Users') }}</div>
                            <div class="fs-5 fw-semibold">--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-file-earmark-text text-info"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Posts') }}</div>
                            <div class="fs-5 fw-semibold">--</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
