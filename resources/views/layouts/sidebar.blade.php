<aside class="sidebar d-none d-lg-flex flex-column" id="sidebar">
    <div class="p-3 border-bottom border-secondary">
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center">
            <x-application-logo class="w-8 h-8" />
            <span class="text-white fw-semibold ms-2 fs-6">{{ config('app.name', 'LSK') }}</span>
        </a>
    </div>

    <nav class="flex-grow-1 py-3 overflow-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid-1x2"></i> {{ __('Dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person"></i> {{ __('Profile') }}
                </a>
            </li>

            @if(auth()->check() && auth()->user()->hasRole('admin'))
                <li class="nav-item mt-2">
                    <small class="text-uppercase text-secondary px-3 fw-semibold" style="font-size:0.7rem;letter-spacing:0.05em;">{{ __('Administration') }}</small>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> {{ __('Admin Dashboard') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags"></i> {{ __('Categories') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.categories.trashed') ? 'active' : '' }}" href="{{ route('admin.categories.trashed') }}"><i class="bi bi-trash"></i> {{ __('Recycle Bin') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> {{ __('Users') }}</a></li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                        <i class="bi bi-envelope"></i> {{ __('Contacts') }}
                        @php $nc = \App\Models\Contact::where('status', 'new')->count(); @endphp
                        @if ($nc > 0)<span class="badge bg-danger ms-1">{{ $nc }}</span>@endif
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" href="{{ route('admin.tags.index') }}"><i class="bi bi-bookmark"></i> {{ __('Tags') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="bi bi-shield-check"></i> {{ __('Roles') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}"><i class="bi bi-folder"></i> {{ __('Media') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.validation-rules.*') ? 'active' : '' }}" href="{{ route('admin.validation-rules.index') }}"><i class="bi bi-shield-shaded"></i> {{ is_string($__val = __('Validation')) ? $__val : 'Validation' }}</a></li>

                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> {{ __('Settings') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}" href="{{ route('admin.maintenance.index') }}"><i class="bi bi-shield-exclamation"></i> {{ __('Maintenance') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.health.*') ? 'active' : '' }}" href="{{ route('admin.health.index') }}"><i class="bi bi-heart-pulse"></i> {{ __('Health') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}" href="{{ route('admin.activity-logs.index') }}"><i class="bi bi-clock-history"></i> {{ __('Activity') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}"><i class="bi bi-journal-text"></i> {{ __('Logs') }}</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}" href="{{ route('admin.backup.index') }}"><i class="bi bi-database"></i> {{ __('Backup') }}</a></li>
            @endif
        </ul>
    </nav>

    <div class="p-3 border-top border-secondary">
        <div class="d-flex align-items-center">
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                <span class="text-white fw-semibold" style="font-size:0.875rem;">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="ms-2 overflow-hidden">
                <div class="text-white fw-medium text-truncate" style="font-size:0.875rem;">{{ Auth::user()->name }}</div>
                <div class="text-secondary text-truncate" style="font-size:0.75rem;">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
</aside>

<div class="sidebar-overlay d-lg-none" id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:1040;" onclick="toggleSidebar()"></div>
