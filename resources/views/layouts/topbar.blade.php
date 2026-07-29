<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom px-4" style="min-height: 64px;">
    <div class="d-flex align-items-center">
        <!-- Mobile Hamburger -->
        <button class="btn btn-link text-dark d-lg-none me-2 p-1" onclick="toggleSidebar()">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>

    <div class="ms-auto d-flex align-items-center">
        <!-- Notifications -->
        @php
            $unreadCount = cache()->remember('notifications.unread.' . auth()->id(), 60, fn () =>
                auth()->user()->unreadNotifications()->count()
            );
            $recentNotifications = auth()->user()->notifications()->latest()->take(8)->get();
        @endphp
        <div class="dropdown me-3" x-data="{ open: false }" @click.outside="open = false">
            <button class="btn btn-link text-dark p-1 position-relative" @click="open = !open" aria-expanded="false">
                <i class="bi bi-bell fs-5"></i>
                @if ($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="width: 360px;" :class="{ show: open }">
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <h6 class="mb-0 fw-semibold" style="font-size: 0.875rem;">{{ __('Notifications') }}</h6>
                    <div>
                        @if ($unreadCount > 0)
                            <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link btn-sm text-decoration-none p-0 me-2" style="font-size: 0.75rem;">{{ __('Mark all read') }}</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-link btn-sm text-decoration-none p-0" style="font-size: 0.75rem;">{{ __('View all') }}</a>
                    </div>
                </div>
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse ($recentNotifications as $notif)
                        @php $data = $notif->data; @endphp
                        <a href="{{ $data['action_url'] ?? '#' }}" class="dropdown-item {{ $notif->read_at ? '' : 'bg-light fw-medium' }}" style="font-size: 0.85rem;">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    @switch($data['type'] ?? 'default')
                                        @case('contact_message') <i class="bi bi-envelope text-primary"></i> @break
                                        @case('category_expired') <i class="bi bi-clock text-warning"></i> @break
                                        @default <i class="bi bi-bell text-secondary"></i>
                                    @endswitch
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="text-truncate">{{ $data['title'] ?? $notif->type }}</div>
                                    @if ($data['body'] ?? null)
                                        <div class="text-muted text-truncate" style="font-size: 0.75rem;">{{ $data['body'] }}</div>
                                    @endif
                                    <small class="text-muted" style="font-size: 0.65rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="dropdown-item text-center text-muted py-3" style="font-size: 0.875rem;">
                            <i class="bi bi-bell-slash d-block mb-1 fs-5"></i>
                            {{ __('No notifications') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="dropdown">
            <button class="btn btn-link text-dark text-decoration-none d-flex align-items-center p-0" data-bs-toggle="dropdown">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <span class="text-white fw-semibold" style="font-size: 0.75rem;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <span class="ms-2 d-none d-md-inline" style="font-size: 0.875rem;">{{ Auth::user()->name }}</span>
                <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i>{{ __('Profile') }}
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>{{ __('Log Out') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

@push('scripts')
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('d-none');
        sidebar.classList.toggle('d-lg-flex');
        overlay.style.display = sidebar.classList.contains('d-none') ? 'none' : 'block';
    }
</script>
@endpush
