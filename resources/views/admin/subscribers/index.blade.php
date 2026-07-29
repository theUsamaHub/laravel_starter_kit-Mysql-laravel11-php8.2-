<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Subscribers') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.subscribers.export') }}" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-download me-1"></i>{{ __('Export CSV') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('Search email or name...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter">
                        <option value="">{{ __('All') }}</option>
                        <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="unsubscribed" {{ request('filter') === 'unsubscribed' ? 'selected' : '' }}>{{ __('Unsubscribed') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-search me-1"></i>{{ __('Filter') }}</button>
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
