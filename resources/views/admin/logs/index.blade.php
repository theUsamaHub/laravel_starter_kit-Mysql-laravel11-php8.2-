<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Application Logs') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.logs.download') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download me-1"></i>{{ __('Download') }}</a>
                <form action="{{ route('admin.logs.clear') }}" method="POST" onsubmit="return confirm('{{ __('Clear all logs?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>{{ __('Clear') }}</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body p-0">
            <div class="bg-dark text-light p-3" style="max-height: 70vh; overflow-y: auto; font-family: monospace; font-size: 0.75rem; line-height: 1.8;">
                @forelse ($logs as $line)
                    @if (str_contains($line, 'ERROR') || str_contains($line, 'error'))
                        <div class="text-danger">{{ $line }}</div>
                    @elseif (str_contains($line, 'WARNING') || str_contains($line, 'warning'))
                        <div class="text-warning">{{ $line }}</div>
                    @else
                        <div class="text-light">{{ $line }}</div>
                    @endif
                @empty
                    <div class="text-muted text-center py-4">No log entries found.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
