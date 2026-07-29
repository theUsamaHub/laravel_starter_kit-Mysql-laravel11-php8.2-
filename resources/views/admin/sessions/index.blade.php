<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">{{ __('Session Manager') }}</h2>
    </x-slot>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('IP Address') }}</th>
                            <th>{{ __('User Agent') }}</th>
                            <th>{{ __('Last Activity') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            <tr>
                                <td>
                                    @if ($session->user_name)
                                        {{ $session->user_name }}
                                        <br><small class="text-muted">{{ $session->user_email }}</small>
                                    @else
                                        <span class="text-muted">{{ __('Guest') }}</span>
                                    @endif
                                    @if ($session->id === session()->getId())
                                        <span class="badge bg-success ms-1">{{ __('Current') }}</span>
                                    @endif
                                </td>
                                <td><code>{{ $session->ip_address ?? '-' }}</code></td>
                                <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $session->user_agent }}">
                                    {{ $session->user_agent ? Str::limit($session->user_agent, 60) : '-' }}
                                </td>
                                <td>{{ $session->last_activity_human }}</td>
                                <td class="text-end">
                                    @if ($session->id !== session()->getId())
                                        <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('{{ __('Revoke this session?') }}')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle me-1"></i>{{ __('Revoke') }}</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('No active sessions.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
