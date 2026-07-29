<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Activity Log') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.activity-logs.export') . '?' . http_build_query(request()->only(['search', 'event', 'user_id'])) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-download me-1"></i>{{ __('Export CSV') }}</a>
                <form action="{{ route('admin.activity-logs.destroy') }}" method="POST" onsubmit="return confirm('{{ __('Clear all logs?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>{{ __('Clear Logs') }}</button>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-secondary border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Total Logs') }}</div>
                    <div class="fs-4 fw-bold">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-info border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Today') }}</div>
                    <div class="fs-4 fw-bold">{{ $stats['today'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="text-muted" style="font-size:0.75rem;">{{ __('Event Breakdown') }}</div>
                    <div class="d-flex gap-3 mt-1">
                        <small><span class="d-inline-block rounded-circle me-1" style="width:8px;height:8px;background:var(--bs-success);"></span>{{ __('Created') }} {{ $stats['events']['created'] ?? 0 }}</small>
                        <small><span class="d-inline-block rounded-circle me-1" style="width:8px;height:8px;background:var(--bs-warning);"></span>{{ __('Updated') }} {{ $stats['events']['updated'] ?? 0 }}</small>
                        <small><span class="d-inline-block rounded-circle me-1" style="width:8px;height:8px;background:var(--bs-danger);"></span>{{ __('Deleted') }} {{ $stats['events']['deleted'] ?? 0 }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4"><div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3"><input type="text" class="form-control" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}"></div>
            <div class="col-md-2">
                <select class="form-select" name="event">
                    <option value="">{{ __('All Events') }}</option>
                    <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>{{ __('Created') }}</option>
                    <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>{{ __('Updated') }}</option>
                    <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>{{ __('Deleted') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="from" value="{{ request('from') }}" placeholder="{{ __('From') }}">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="to" value="{{ request('to') }}" placeholder="{{ __('To') }}">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-outline-secondary flex-grow-1"><i class="bi bi-search me-1"></i>{{ __('Filter') }}</button>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-danger"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div></div>

    <div class="card"><div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>{{ __('Time') }}</th><th>{{ __('User') }}</th><th>{{ __('Event') }}</th><th>{{ __('Model') }}</th><th>{{ __('Details') }}</th></tr></thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td class="text-muted" style="font-size:0.8rem;">{{ $log->created_at->diffForHumans() }}</td>
                            <td>{{ $log->user?->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ match($log->event) { 'created' => 'success', 'updated' => 'warning', 'deleted' => 'danger', default => 'secondary' } }}">{{ $log->event }}</span></td>
                            <td><code style="font-size:0.75rem;">{{ class_basename($log->auditable_type) }}</code> #{{ $log->auditable_id }}</td>
                            <td style="font-size:0.8rem; max-width:300px;">
                                @if ($log->new_values)
                                    @foreach (array_slice($log->new_values, 0, 3) as $key => $val)
                                        <span class="text-muted">{{ $key }}:</span> {{ is_array($val) ? json_encode($val) : Str::limit($val, 30) }}<br>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('No activity logs found.') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($logs->hasPages())<div class="card-footer bg-white">{{ $logs->links() }}</div>@endif
    </div>
</x-app-layout>
