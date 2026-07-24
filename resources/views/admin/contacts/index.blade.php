<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Contact Messages') }}</h2>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search & Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="{{ __('Search messages...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="status">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>{{ __('Read') }}</option>
                        <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>{{ __('Replied') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-search me-1"></i>{{ __('Filter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td class="fw-medium">{{ $contact->name }}</td>
                                <td class="text-muted">{{ $contact->email }}</td>
                                <td>{{ $contact->subject ?: '-' }}</td>
                                <td>
                                    @if ($contact->status === 'new')
                                        <span class="badge bg-primary">{{ __('New') }}</span>
                                    @elseif ($contact->status === 'read')
                                        <span class="badge bg-info">{{ __('Read') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ __('Replied') }}</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $contact->created_at->diffForHumans() }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-envelope"></i>
                                        <p>{{ __('No contact messages found.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($contacts->hasPages())
            <div class="card-footer bg-white">
                {{ $contacts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
