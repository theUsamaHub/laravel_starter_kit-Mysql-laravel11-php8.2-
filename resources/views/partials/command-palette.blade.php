<div
    x-data="commandPalette()"
    x-on:keydown.window.prevent.cmd.k="toggle()"
    x-on:keydown.window.prevent.ctrl.k="toggle()"
    x-on:keydown.escape="close()"
    x-cloak
>
    <div x-show="open" x-transition.opacity class="position-fixed" style="inset:0;z-index:1055;background:rgba(0,0,0,0.5);" x-on:click="close()"></div>

    <div x-show="open" x-transition class="position-fixed" style="top:10%;left:50%;transform:translateX(-50%);z-index:1056;width:100%;max-width:480px;">
        <div class="card shadow-lg border-0">
            <div class="card-body p-0">
                <div class="p-3 border-bottom">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control border-0 shadow-none"
                            x-ref="searchInput"
                            x-model="query"
                            placeholder="Search pages..."
                            x-on:keydown.prevent.enter="navigate()"
                            x-on:keydown.prevent.down="next()"
                            x-on:keydown.prevent.up="prev()"
                        >
                        <span class="input-group-text bg-transparent border-0 text-muted"><kbd class="bg-light px-1 rounded" style="font-size:0.7rem;">ESC</kbd></span>
                    </div>
                </div>
                <ul class="list-unstyled mb-0" style="max-height:360px;overflow-y:auto;">
                    <template x-for="(item, index) in filtered" :key="item.route">
                        <li>
                            <a
                                :href="item.url"
                                class="d-flex align-items-center px-3 py-2 text-decoration-none"
                                :class="index === activeIndex ? 'bg-primary text-white' : 'text-dark'"
                                @click.prevent="go(item)"
                                @mouseenter="activeIndex = index"
                            >
                                <i :class="item.icon" class="me-2" style="width:1.2rem;"></i>
                                <span class="flex-grow-1" x-text="item.name"></span>
                                <small class="opacity-50" x-text="item.category"></small>
                            </a>
                        </li>
                    </template>
                    <li x-show="filtered.length === 0 && query.length > 0">
                        <div class="px-3 py-4 text-center text-muted">
                            <i class="bi bi-search fs-4 d-block mb-1"></i>
                            <small>No results for "<span x-text="query"></span>"</small>
                        </div>
                    </li>
                </ul>
                <div class="p-2 border-top bg-light d-flex gap-3 justify-content-center" style="font-size:0.7rem;">
                    <span><kbd class="bg-white px-1 rounded">↑↓</kbd> Navigate</span>
                    <span><kbd class="bg-white px-1 rounded">↵</kbd> Open</span>
                    <span><kbd class="bg-white px-1 rounded">ESC</kbd> Close</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function commandPalette() {
    return {
        open: false,
        query: '',
        activeIndex: 0,
        pages: [
            { name: 'Dashboard',          url: '{{ route("dashboard") }}',            icon: 'bi bi-grid-1x2',      category: 'General' },
            { name: 'Profile',            url: '{{ route("profile.edit") }}',          icon: 'bi bi-person',        category: 'General' },
            { name: 'Admin Dashboard',    url: '{{ route("admin.dashboard") }}',       icon: 'bi bi-speedometer2',  category: 'Admin' },
            { name: 'Categories',         url: '{{ route("admin.categories.index") }}', icon: 'bi bi-tags',         category: 'Admin' },
            { name: 'Recycle Bin',        url: '{{ route("admin.categories.trashed") }}', icon: 'bi bi-trash',     category: 'Admin' },
            { name: 'Users',              url: '{{ route("admin.users.index") }}',      icon: 'bi bi-people',        category: 'Admin' },
            { name: 'Contacts',           url: '{{ route("admin.contacts.index") }}',   icon: 'bi bi-envelope',      category: 'Admin' },
            { name: 'Tags',               url: '{{ route("admin.tags.index") }}',       icon: 'bi bi-bookmark',      category: 'Admin' },
            { name: 'Roles',              url: '{{ route("admin.roles.index") }}',      icon: 'bi bi-shield-check',  category: 'Admin' },
            { name: 'Media Library',      url: '{{ route("admin.media.index") }}',      icon: 'bi bi-folder',        category: 'Admin' },
            { name: 'Validation Rules',   url: '{{ route("admin.validation-rules.index") }}', icon: 'bi bi-shield-shaded', category: 'Admin' },
            { name: 'Settings',           url: '{{ route("admin.settings.index") }}',   icon: 'bi bi-gear',          category: 'Admin' },
            { name: 'Maintenance',        url: '{{ route("admin.maintenance.index") }}', icon: 'bi bi-shield-exclamation', category: 'Admin' },
            { name: 'Health Dashboard',   url: '{{ route("admin.health.index") }}',    icon: 'bi bi-heart-pulse',   category: 'Admin' },
            { name: 'IP Restrictions',    url: '{{ route("admin.ip-restrictions.index") }}', icon: 'bi bi-shield-lock', category: 'Admin' },
            { name: 'Sessions',            url: '{{ route("admin.sessions.index") }}',    icon: 'bi bi-person-badge',  category: 'Admin' },
            { name: 'Activity Logs',      url: '{{ route("admin.activity-logs.index") }}', icon: 'bi bi-clock-history', category: 'Admin' },
            { name: 'Log Viewer',         url: '{{ route("admin.logs.index") }}',       icon: 'bi bi-journal-text',  category: 'Admin' },
            { name: 'Backups',            url: '{{ route("admin.backup.index") }}',     icon: 'bi bi-database',      category: 'Admin' },
        ],
        get filtered() {
            if (!this.query) return this.pages;
            const q = this.query.toLowerCase();
            return this.pages.filter(p =>
                p.name.toLowerCase().includes(q) ||
                p.category.toLowerCase().includes(q)
            );
        },
        toggle() { this.open = !this.open; if (this.open) { this.query = ''; this.activeIndex = 0; this.$nextTick(() => this.$refs.searchInput?.focus()); } },
        close() { this.open = false; },
        navigate() { if (this.filtered[this.activeIndex]) this.go(this.filtered[this.activeIndex]); },
        next() { this.activeIndex = Math.min(this.activeIndex + 1, this.filtered.length - 1); },
        prev() { this.activeIndex = Math.max(this.activeIndex - 1, 0); },
        go(item) { window.location.href = item.url; },
    };
}
</script>
