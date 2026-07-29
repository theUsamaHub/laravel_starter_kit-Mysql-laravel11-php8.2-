<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Subscribers') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.subscribers.export') . '?' . http_build_query(request()->only(['search', 'filter', 'from', 'to'])) }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download me-1"></i>{{ __('Export CSV') }}
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Total') }}</div>
                    <div class="fs-4 fw-bold">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-success border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Active') }}</div>
                    <div class="fs-4 fw-bold">{{ $stats['active'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-secondary border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Unsubscribed') }}</div>
                    <div class="fs-4 fw-bold">{{ $stats['unsubscribed'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('Search email or name...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="filter">
                        <option value="">{{ __('All') }}</option>
                        <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="unsubscribed" {{ request('filter') === 'unsubscribed' ? 'selected' : '' }}>{{ __('Unsubscribed') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="from" value="{{ request('from') }}" placeholder="{{ __('From date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="to" value="{{ request('to') }}" placeholder="{{ __('To date') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-secondary flex-grow-1"><i class="bi bi-search me-1"></i>{{ __('Filter') }}</button>
                    <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-danger"><i class="bi bi-x"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Subscribed') }}</th>
                            <th>{{ __('IP') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscribers as $subscriber)
                            <tr>
                                <td><code>{{ $subscriber->email }}</code></td>
                                <td>{{ $subscriber->name ?? '-' }}</td>
                                <td>
                                    @if ($subscriber->isActive())
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ __('Unsubscribed') }}</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $subscriber->subscribed_at?->diffForHumans() ?? '-' }}</td>
                                <td><code>{{ $subscriber->ip_address ?? '-' }}</code></td>
                                <td class="text-end">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this subscriber?') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">{{ __('No subscribers found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($subscribers->hasPages())
            <div class="card-footer bg-white">{{ $subscribers->links() }}</div>
        @endif
    </div>
</x-app-layout>
