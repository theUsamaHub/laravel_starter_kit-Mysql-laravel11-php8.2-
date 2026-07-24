<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('User Details') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-pencil me-1"></i>{{ __('Edit') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-semibold" style="width: 200px;">{{ __('Name') }}</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Email') }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Roles') }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-{{ $role->slug === 'admin' ? 'primary' : 'secondary' }}">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Email Verified') }}</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">{{ __('Verified') }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ __('Not Verified') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Joined') }}</td>
                                <td>{{ $user->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-danger">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold text-danger">{{ __('Danger Zone') }}</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted" style="font-size: 0.875rem;">
                        {{ __('Deleting this user will permanently remove their account and all associated data.') }}
                    </p>
                    @if ($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-trash me-1"></i>{{ __('Delete User') }}
                            </button>
                        </form>
                    @else
                        <div class="alert alert-warning py-2 mb-0" style="font-size: 0.875rem;">
                            {{ __('You cannot delete your own account from here.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
