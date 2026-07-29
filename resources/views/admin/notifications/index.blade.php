<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 fw-semibold">{{ __('Notifications') }}</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" class="btn btn-outline-secondary btn-sm {{ request('filter') === 'unread' ? 'active' : '' }}">
                    <i class="bi bi-bell me-1"></i>{{ __('Unread') }}
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary btn-sm {{ !request('filter') ? 'active' : '' }}">
                    <i class="bi bi-list me-1"></i>{{ __('All') }}
                </a>
                @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                @if ($unreadCount > 0)
                    <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-outline-primary btn-sm"><i class="bi bi-check-all me-1"></i>{{ __('Mark All Read') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @forelse ($notifications as $notif)
                    @php $data = $notif->data; @endphp
                    <div class="list-group-item list-group-item-action d-flex align-items-start {{ $notif->read_at ? '' : 'bg-light' }}">
                        <div class="flex-shrink-0 me-3 mt-1">
                            @switch($data['type'] ?? 'default')
                                @case('contact_message') <i class="bi bi-envelope text-primary fs-5"></i> @break
                                @case('category_expired') <i class="bi bi-clock text-warning fs-5"></i> @break
                                @default <i class="bi bi-bell text-secondary fs-5"></i>
                            @endswitch
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-medium {{ $notif->read_at ? '' : 'fw-semibold' }}">{{ $data['title'] ?? $notif->type }}</div>
                                    @if ($data['body'] ?? null)
                                        <div class="text-muted mt-1" style="font-size: 0.875rem;">{{ $data['body'] }}</div>
                                    @endif
                                </div>
                                <small class="text-muted ms-3 text-nowrap">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                @if (!$notif->read_at)
                                    <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success" style="font-size: 0.75rem;"><i class="bi bi-check me-1"></i>{{ __('Mark Read') }}</button>
                                    </form>
                                @endif
                                @if ($data['action_url'] ?? null)
                                    <a href="{{ $data['action_url'] }}" class="btn btn-sm btn-outline-primary" style="font-size: 0.75rem;"><i class="bi bi-eye me-1"></i>{{ __('View') }}</a>
                                @endif
                                <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Delete this notification?') }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" style="font-size: 0.75rem;"><i class="bi bi-trash me-1"></i>{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                        <p>{{ __('No notifications found.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
        @if ($notifications->hasPages())
            <div class="card-footer bg-white">{{ $notifications->links() }}</div>
        @endif
    </div>
</x-app-layout>
