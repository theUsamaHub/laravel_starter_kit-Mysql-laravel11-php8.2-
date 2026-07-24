<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('Admin Dashboard') }}</h2>
    </x-slot>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        @php
            $stats = [
                ['label' => __('Users'), 'count' => \App\Models\User::count(), 'icon' => 'bi-people', 'color' => 'primary', 'route' => 'admin.users.index'],
                ['label' => __('Categories'), 'count' => \App\Models\Category::count(), 'icon' => 'bi-tags', 'color' => 'success', 'route' => 'admin.categories.index'],
                ['label' => __('Contacts'), 'count' => \App\Models\Contact::count(), 'icon' => 'bi-envelope', 'color' => 'info', 'route' => 'admin.contacts.index', 'badge' => \App\Models\Contact::where('status', 'new')->count()],
                ['label' => __('Tags'), 'count' => \App\Models\Tag::count(), 'icon' => 'bi-bookmark', 'color' => 'warning', 'route' => 'admin.tags.index'],
                ['label' => __('Roles'), 'count' => \App\Models\Role::count(), 'icon' => 'bi-shield-check', 'color' => 'secondary', 'route' => 'admin.roles.index'],
                ['label' => __('Media'), 'count' => \App\Models\Media::count(), 'icon' => 'bi-folder', 'color' => 'dark', 'route' => 'admin.media.index'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="col-md-4 col-lg-2">
                <a href="{{ route($stat['route']) }}" class="text-decoration-none">
                    <div class="card border-start border-{{ $stat['color'] }} border-4 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $stat['label'] }}</div>
                                    <div class="fs-4 fw-bold">{{ $stat['count'] }}</div>
                                </div>
                                <div class="bg-{{ $stat['color'] }} bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                    <i class="bi {{ $stat['icon'] }} text-{{ $stat['color'] }}"></i>
                                </div>
                            </div>
                            @if (!empty($stat['badge']) && $stat['badge'] > 0)
                                <span class="badge bg-danger mt-1">{{ $stat['badge'] }} {{ __('new') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Users & Contacts (Last 7 Days)') }}</h6></div>
                <div class="card-body">
                    @php
                        $days = collect();
                        for ($i = 6; $i >= 0; $i--) {
                            $date = now()->subDays($i);
                            $days->push([
                                'label' => $date->format('M d'),
                                'users' => \App\Models\User::whereDate('created_at', $date)->count(),
                                'contacts' => \App\Models\Contact::whereDate('created_at', $date)->count(),
                            ]);
                        }
                        $maxVal = max(1, $days->max(fn($d) => max($d['users'], $d['contacts'])));
                    @endphp
                    <div class="d-flex align-items-end gap-2" style="height: 200px;">
                        @foreach ($days as $day)
                            <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-end" style="height: 100%;">
                                <div class="d-flex gap-1 align-items-end" style="height: 180px;">
                                    <div class="rounded-top" style="width:12px; height: {{ ($day['users'] / $maxVal) * 160 }}px; background: var(--bs-primary); min-height: 2px;" title="{{ $day['users'] }} users"></div>
                                    <div class="rounded-top" style="width:12px; height: {{ ($day['contacts'] / $maxVal) * 160 }}px; background: var(--bs-info); min-height: 2px;" title="{{ $day['contacts'] }} contacts"></div>
                                </div>
                                <small class="text-muted mt-1" style="font-size:0.65rem;">{{ $day['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex gap-3 justify-content-center mt-2" style="font-size:0.75rem;">
                        <span><span class="d-inline-block rounded me-1" style="width:10px;height:10px;background:var(--bs-primary);"></span>{{ __('Users') }}</span>
                        <span><span class="d-inline-block rounded me-1" style="width:10px;height:10px;background:var(--bs-info);"></span>{{ __('Contacts') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Activity Today') }}</h6></div>
                <div class="card-body">
                    @php
                        $todayLogs = \App\Models\ActivityLog::whereDate('created_at', today())->get();
                        $created = $todayLogs->where('event', 'created')->count();
                        $updated = $todayLogs->where('event', 'updated')->count();
                        $deleted = $todayLogs->where('event', 'deleted')->count();
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1"><small>{{ __('Created') }}</small><small class="fw-bold">{{ $created }}</small></div>
                        <div class="progress" style="height:8px;"><div class="progress-bar bg-success" style="width:{{ $created > 0 ? 100 : 0 }}%"></div></div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1"><small>{{ __('Updated') }}</small><small class="fw-bold">{{ $updated }}</small></div>
                        <div class="progress" style="height:8px;"><div class="progress-bar bg-warning" style="width:{{ $updated > 0 ? ($updated / max(1, $todayLogs->count()) * 100) : 0 }}%"></div></div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1"><small>{{ __('Deleted') }}</small><small class="fw-bold">{{ $deleted }}</small></div>
                        <div class="progress" style="height:8px;"><div class="progress-bar bg-danger" style="width:{{ $deleted > 0 ? ($deleted / max(1, $todayLogs->count()) * 100) : 0 }}%"></div></div>
                    </div>
                    <hr>
                    <div class="text-center text-muted" style="font-size:0.8rem;">{{ __('Total: ') . $todayLogs->count() . __(' actions today') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent + Quick Actions -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">{{ __('Recent Users') }}</h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">{{ __('View All') }}</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead><tr><th>{{ __('Name') }}</th><th>{{ __('Email') }}</th><th>{{ __('Roles') }}</th><th>{{ __('Joined') }}</th></tr></thead>
                            <tbody>
                                @forelse(\App\Models\User::with('roles')->latest()->take(5)->get() as $user)
                                    <tr>
                                        <td class="fw-medium">{{ $user->name }}</td>
                                        <td class="text-muted">{{ $user->email }}</td>
                                        <td>@foreach ($user->roles as $role)<span class="badge bg-{{ $role->slug === 'admin' ? 'primary' : 'secondary' }}">{{ $role->name }}</span>@endforeach</td>
                                        <td class="text-muted">{{ $user->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">{{ __('No users yet.') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h6 class="mb-0 fw-semibold">{{ __('Quick Actions') }}</h6></div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary btn-sm text-start"><i class="bi bi-plus-circle me-2"></i>{{ __('Create Category') }}</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-info btn-sm text-start"><i class="bi bi-people me-2"></i>{{ __('Manage Users') }}</a>
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-warning btn-sm text-start"><i class="bi bi-bookmark me-2"></i>{{ __('Manage Tags') }}</a>
                        <a href="{{ route('admin.backup.index') }}" class="btn btn-outline-success btn-sm text-start"><i class="bi bi-database me-2"></i>{{ __('Database Backup') }}</a>
                        <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary btn-sm text-start"><i class="bi bi-journal-text me-2"></i>{{ __('View Logs') }}</a>
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-dark btn-sm text-start"><i class="bi bi-clock-history me-2"></i>{{ __('Activity Log') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
