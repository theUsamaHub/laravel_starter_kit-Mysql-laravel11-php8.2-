<div
    x-data="commandPalette()"
    x-on:keydown.window.prevent.cmd.k="toggle()"
    x-on:keydown.window.prevent.ctrl.k="toggle()"
    x-on:keydown.escape="close()"
    x-cloak
>
    <div x-show="open" x-transition.opacity class="position-fixed" style="inset:0;z-index:1055;background:rgba(0,0,0,0.5);" x-on:click="close()"></div>

    <div x-show="open" x-transition class="position-fixed" style="top:10%;left:50%;transform:translateX(-50%);z-index:1056;width:100%;max-width:520px;">
        <div class="card shadow border-0">
            <div class="card-body p-0">
                <div class="p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-search text-muted me-2"></i>
                        <input
                            type="text"
                            class="form-control border-0 shadow-none px-0"
                            x-ref="searchInput"
                            x-model="query"
                            placeholder="Search pages..."
                            style="outline:none;font-size:0.95rem;"
                            x-on:keydown.prevent.enter="navigate()"
                            x-on:keydown.prevent.down="next()"
                            x-on:keydown.prevent.up="prev()"
                        >
                        <kbd class="bg-light px-2 py-1 rounded border text-muted" style="font-size:0.65rem;">ESC</kbd>
                    </div>
                </div>
                <ul class="list-unstyled mb-0" style="max-height:360px;overflow-y:auto;">
                    <template x-for="(item, index) in filtered" :key="item.route">
                        <li>
                            <a
                                :href="item.url"
                                class="d-flex align-items-center px-3 py-2 text-decoration-none border-bottom border-light"
                                :class="index === activeIndex ? 'bg-primary bg-opacity-10 text-primary' : 'text-dark'"
                                @click.prevent="go(item)"
                                @mouseenter="activeIndex = index"
                            >
                                <i :class="item.icon" class="me-3 text-center" style="width:1.2rem;font-size:0.9rem;"></i>
                                <span class="flex-grow-1" x-text="item.name" style="font-size:0.85rem;"></span>
                                <span class="badge bg-light text-muted fw-normal" x-text="item.category" style="font-size:0.65rem;"></span>
                            </a>
                        </li>
                    </template>
                    <li x-show="filtered.length === 0 && query.length > 0">
                        <div class="px-3 py-5 text-center text-muted">
                            <i class="bi bi-search fs-3 d-block mb-2"></i>
                            <small>No results for "<span x-text="query" class="fw-medium"></span>"</small>
                        </div>
                    </li>
                </ul>
                <div class="p-2 border-top d-flex gap-3 justify-content-center" style="font-size:0.65rem;">
                    <span><kbd class="bg-white px-1 rounded border">↑</kbd> <kbd class="bg-white px-1 rounded border">↓</kbd> Navigate</span>
                    <span><kbd class="bg-white px-1 rounded border">↵</kbd> Open</span>
                    <span><kbd class="bg-white px-1 rounded border">ESC</kbd> Close</span>
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
            { name: 'Subscribers',         url: '{{ route("admin.subscribers.index") }}', icon: 'bi bi-envelope-paper', category: 'Admin' },
            { name: 'Notifications',       url: '{{ route("admin.notifications.index") }}', icon: 'bi bi-bell',         category: 'Admin' },
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
