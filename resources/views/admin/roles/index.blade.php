<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Roles & Permissions') }}</h2>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>{{ __('Add Role') }}
            </a>
        </div>
    </x-slot>

    <!-- Discovered Modules -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold"><i class="bi bi-box-seam me-1"></i>{{ __('Discovered Modules') }}</h6>
        </div>
        <div class="card-body">
            <small class="text-muted d-block mb-3">{{ __('Modules are auto-discovered from Admin controllers. Add a new controller to app/Http/Controllers/Admin/ and its permissions appear automatically.') }}</small>
            <div class="row g-2">
                @foreach ($modules as $slug => $module)
                    <div class="col-md-4 col-lg-3">
                        <div class="card border h-100">
                            <div class="card-body p-3">
                                <div class="fw-semibold mb-1">{{ $module['name'] }}</div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($module['capabilities'] as $cap)
                                        <span class="badge bg-light text-dark">{{ $cap }}</span>
                                    @endforeach
                                </div>
                                <div class="text-muted mt-1" style="font-size:0.7rem;">
                                    <code>{{ class_basename($module['controller']) }}</code>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('Users') }}</th>
                            <th>{{ __('Permissions') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <td class="fw-medium">{{ $role->name }}</td>
                                <td><code>{{ $role->slug }}</code></td>
                                <td>{{ $role->users_count }}</td>
                                <td>
                                    @php $perms = $role->permissions ?? []; @endphp
                                    @if (count($perms) > 0)
                                        <span class="badge bg-success">{{ count($perms) }} {{ __('permissions') }}</span>
                                        @if (count($perms) > 3)
                                            <small class="text-muted ms-1" style="font-size:0.7rem;">
                                                {{ implode(', ', array_slice($perms, 0, 3)) }}...
                                            </small>
                                        @else
                                            <small class="text-muted ms-1" style="font-size:0.7rem;">
                                                {{ implode(', ', $perms) }}
                                            </small>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">{{ __('No permissions') }}</span>
                                    @endif
                                </td>
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
