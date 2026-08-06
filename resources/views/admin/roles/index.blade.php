<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Roles') }}</h2>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>{{ __('Add Role') }}
            </a>
        </div>
    </x-slot>

    <!-- Roles Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Users') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td class="fw-medium">{{ $role->name }}</td>
                                <td><code>{{ $role->slug }}</code></td>
                                <td>{{ $role->description ?? '-' }}</td>
                                <td>{{ $role->users_count }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                        @if ($role->users_count === 0)
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm()">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('No roles found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
