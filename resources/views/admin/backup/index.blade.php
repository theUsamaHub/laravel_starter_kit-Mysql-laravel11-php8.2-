<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Database Backup') }}</h2>
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <button class="btn btn-primary btn-sm"><i class="bi bi-download me-1"></i>{{ __('Create Backup') }}</button>
            </form>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>{{ __('Filename') }}</th><th>{{ __('Size') }}</th><th>{{ __('Date') }}</th><th class="text-end">{{ __('Actions') }}</th></tr></thead>
                    <tbody>
                        @forelse ($backups as $backup)
                            <tr>
                                <td class="fw-medium"><i class="bi bi-file-earmark-zip text-primary me-1"></i>{{ $backup['name'] }}</td>
                                <td>{{ $backup['size'] }}</td>
                                <td class="text-muted">{{ date('M d, Y H:i:s', $backup['date']) }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.backup.download', $backup['name']) }}" class="btn btn-outline-success"><i class="bi bi-download"></i></a>
                                        <form action="{{ route('admin.backup.destroy', $backup['name']) }}" method="POST" class="d-inline" onsubmit="return confirm()">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5">
                                <div class="empty-state"><i class="bi bi-database"></i><p>{{ __('No backups yet.') }}</p></div>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
