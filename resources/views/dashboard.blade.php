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
                            <div class="fs-5 fw-semibold">{{ \App\Models\Category::count() }}</div>
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
                            <div class="fs-5 fw-semibold">{{ \App\Models\User::count() }}</div>
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
                            <i class="bi bi-envelope text-info"></i>
                        </div>
                        <div class="ms-3">
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Contact Messages') }}</div>
                            <div class="fs-5 fw-semibold">{{ \App\Models\Contact::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">{{ __('Recent Categories') }}</h6>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Category::latest()->take(5)->get() as $category)
                                    <tr>
                                        <td class="fw-medium">{{ $category->name }}</td>
                                        <td>
                                            @if ($category->is_active)
                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ $category->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">{{ __('No categories yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Quick Actions') }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary btn-sm text-start">
                                <i class="bi bi-plus-circle me-2"></i>{{ __('Create Category') }}
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                                <i class="bi bi-tags me-2"></i>{{ __('Manage Categories') }}
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-info btn-sm text-start">
                            <i class="bi bi-person me-2"></i>{{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
