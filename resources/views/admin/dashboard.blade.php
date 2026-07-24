<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="row g-4">
        <!-- Stats -->
        <div class="col-md-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Total Users') }}</div>
                            <div class="fs-4 fw-bold">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-people text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Categories') }}</div>
                            <div class="fs-4 fw-bold">{{ \App\Models\Category::count() }}</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-tags text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Active Roles') }}</div>
                            <div class="fs-4 fw-bold">{{ \App\Models\Role::count() }}</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-shield-check text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem;">{{ __('Contact Messages') }}</div>
                            <div class="fs-4 fw-bold">{{ \App\Models\Contact::count() }}</div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-envelope text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">{{ __('Recent Users') }}</h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Roles') }}</th>
                                    <th>{{ __('Joined') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\User::with('roles')->latest()->take(5)->get() as $user)
                                    <tr>
                                        <td class="fw-medium">{{ $user->name }}</td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-{{ $role->slug === 'admin' ? 'primary' : 'secondary' }}">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">{{ __('No users yet.') }}</td>
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
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary btn-sm text-start">
                            <i class="bi bi-plus-circle me-2"></i>{{ __('Create Category') }}
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm text-start">
                            <i class="bi bi-tags me-2"></i>{{ __('Manage Categories') }}
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info btn-sm text-start">
                            <i class="bi bi-people me-2"></i>{{ __('Manage Users') }}
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-warning btn-sm text-start">
                            <i class="bi bi-envelope me-2"></i>{{ __('View Contacts') }}
                            @php $newContacts = \App\Models\Contact::where('status', 'new')->count(); @endphp
                            @if ($newContacts > 0)
                                <span class="badge bg-danger ms-1">{{ $newContacts }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
