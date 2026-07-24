<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Contact Message') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                <td>{{ $contact->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Email') }}</td>
                                <td>
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Subject') }}</td>
                                <td>{{ $contact->subject ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Status') }}</td>
                                <td>
                                    @if ($contact->status === 'new')
                                        <span class="badge bg-primary">{{ __('New') }}</span>
                                    @elseif ($contact->status === 'read')
                                        <span class="badge bg-info">{{ __('Read') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ __('Replied') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('IP Address') }}</td>
                                <td><code>{{ $contact->ip_address ?: '-' }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">{{ __('Received') }}</td>
                                <td>{{ $contact->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Message') }}</h6>
                </div>
                <div class="card-body">
                    <div class="bg-light rounded p-3" style="white-space: pre-wrap;">{{ $contact->message }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">{{ __('Actions') }}</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?: 'Your message' }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-reply me-1"></i>{{ __('Reply via Email') }}
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this message?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="bi bi-trash me-1"></i>{{ __('Delete Message') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
