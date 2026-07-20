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
        <div class="dropdown me-3">
            <button class="btn btn-link text-dark p-1 position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="width: 320px;">
                <h6 class="dropdown-header">{{ __('Notifications') }}</h6>
                <div class="dropdown-item text-center text-muted py-3" style="font-size: 0.875rem;">
                    {{ __('No new notifications') }}
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
