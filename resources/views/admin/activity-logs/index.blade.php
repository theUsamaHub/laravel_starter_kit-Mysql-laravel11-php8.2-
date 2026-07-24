<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Activity Log') }}</h2>
            <form action="{{ route('admin.activity-logs.destroy') }}" method="POST" onsubmit="return confirm('{{ __('Clear all logs?') }}')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>{{ __('Clear Logs') }}</button>
            </form>
        </div>
    </x-slot>

    <div class="card mb-4"><div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4"><input type="text" class="form-control" name="search" placeholder="{{ __('Search...') }}" value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select class="form-select" name="event">
                    <option value="">{{ __('All Events') }}</option>
                    <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>{{ __('Created') }}</option>
                    <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>{{ __('Updated') }}</option>
                    <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}{{ __('Deleted') }}</option>
                </select>
            </div>
            <div class="col-md-3"><button class="btn btn-outline-secondary w-100"><i class="bi bi-search me-1"></i>{{ __('Filter') }}</button></div>
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
