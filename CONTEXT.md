# Laravel Starter Kit — Full Project Context

> Use this document to give any AI complete context about this Laravel 13 project without reading every file.

## Tech Stack
- **Laravel 13.18.0**, PHP 8.5.8, PostgreSQL (default), SQLite for tests
- **Bootstrap 5.3.3** + **Bootstrap Icons 1.11.3** via SCSS (`resources/css/app.scss`)
- **Alpine.js 3.15.12** for frontend interactivity
- **Vite 8** build tool with `laravel-vite-plugin`
- **Laravel Sanctum** for API token auth
- **Queue**: `database` driver (via `composer dev` with `queue:listen`)
- **Scheduler**: runs every minute via `schedule:work` (included in `composer dev`)
- **Database**: 18 tables — PostgreSQL recommended, SQLite for dev/testing

## Architecture Overview

### Authentication
- **Web**: Session-based via Laravel Breeze (login, register, password reset, email verification, password confirmation)
- **API**: Token-based via Sanctum (register/login/logout, Bearer token)
- **Rate limiting**: 5 login attempts per email+IP throttle

### Authorization (RBAC)
- Two roles: `admin` (super-admin, full access to admin panel) and `user` (regular)
- `RoleMiddleware`: checks if user has a specific role slug
- Admin routes are wrapped in `role:admin` middleware

### Admin Panel
- Prefix `/admin`, middleware group: `auth, verified, role:admin, ip-restrict`
- Sidebar with all management links, badges for pending contacts and unread notifications
- Layout: `x-app-layout` (extends `layouts/app.blade.php` with sidebar + topbar + command palette)
- Topbar has: app logo, notification bell with dropdown + count badge, search button (Ctrl+K), user dropdown

### Public Pages
- `/` — Welcome page with hero, features, newsletter form, footer
- `/about`, `/services`, `/contact` — Static/info pages
- All public pages use shared `partials/public-navbar` (Home, About, Services, Contact) and `partials/public-footer`
- Newsletter subscription form on welcome page (`POST /subscribe`)

### API (v1)
- Prefix `/api/v1`, JSON resources (`UserResource`, `CategoryResource`)
- Health check (`GET /api/v1/health`)
- Auth: register, login, logout (Sanctum tokens)
- Profile: get/update current user
- Admin endpoints: full CRUD for categories, users

---

## All Route Files

### `routes/web.php`
| Method | URI | Controller | Name | Middleware |
|--------|-----|-----------|------|-----------|
| GET | `/` | view: welcome | `home` | web |
| POST | `/contact` | `ContactController@store` | `contact.store` | web |
| GET | `/dashboard` | view: dashboard | `dashboard` | auth, verified |
| GET/PATCH/DELETE | `/profile` | `ProfileController` | `profile.*` | auth, verified |

### `routes/auth.php`
| Method | URI | Name | Notes |
|--------|-----|------|-------|
| GET/POST | `/register` | `register` | Guest |
| GET/POST | `/login` | `login` | Guest, rate-limited 5 attempts |
| POST | `/logout` | `logout` | Auth |
| GET/POST | `/forgot-password` | `password.request` / `password.email` | Guest |
| GET/POST | `/reset-password/{token}` | `password.reset` / `password.store` | Guest |
| GET | `/verify-email` | `verification.notice` | Auth |
| GET | `/verify-email/{id}/{hash}` | `verification.verify` | Signed, throttled |
| POST | `/email/verification-notification` | `verification.send` | Throttled |
| GET/POST | `/confirm-password` | `password.confirm` | Auth |
| PUT | `/password` | `password.update` | Auth |

### `routes/admin.php`
All under `/admin`, prefix `admin.`, middleware: `auth, verified, role:admin, ip-restrict`

| Route | Methods | Controller | Notes |
|-------|---------|-----------|-------|
| `/` | GET | view: dashboard | Admin Dashboard |
| `/categories` | resource | `CategoryController` | Full CRUD + `trashed`, `restore`, `force-delete` |
| `/users` | index/show/edit/update/destroy | `UserController` | No create — users register themselves |
| `/contacts` | index/show/destroy | `ContactController` | Contact submissions inbox |
| `/media` | index/store/destroy | `MediaController` | File upload & management |
| `/settings` | index/update/store/destroy | `SettingController` | DB-backed grouped settings |
| `/roles` | resource (no show) | `RoleController` | Role management (name, slug, description) |
| `/tags` | resource (no show) | `TagController` | Tag CRUD with color picker |
| `/activity-logs` | index/export/destroy | `ActivityLogController` | Audit trail, CSV export |
| `/ip-restrictions` | index/update | `IpRestrictionController` | IP whitelist management |
| `/notifications` | index/read/read-all/destroy | `NotificationController` | In-app notification inbox |
| `/subscribers` | index/export/destroy | `SubscriberController` | Newsletter subscribers |
| `/sessions` | index/destroy | `SessionController` | Active session management |
| `/maintenance` | index/toggle/message/bypass-routes | `MaintenanceController` | DB-backed maintenance mode |
| `/health` | GET | `HealthController@index` | System health dashboard |
| `/logs` | index/clear/download | `LogViewerController` | Real-time log viewer |
| `/backup` | index/create/download/destroy | `BackupController` | PostgreSQL dump backups |

### `routes/public.php`
| Method | URI | Name |
|--------|-----|------|
| GET | `/about` | `public.about` |
| GET | `/services` | `public.services` |
| GET | `/contact` | `public.contact` |
| POST | `/subscribe` | `public.subscribe` |

### `routes/api.php`
Prefix `/api/v1`
| Method | URI | Controller | Middleware |
|--------|-----|-----------|-----------|
| GET | `/health` | — | api |
| POST | `/auth/register` | `Api\V1\Auth\RegisteredUserController@store` | guest |
| POST | `/auth/login` | `Api\V1\Auth\AuthenticatedSessionController@store` | guest |
| POST | `/auth/logout` | `Api\V1\Auth\AuthenticatedSessionController@destroy` | auth:sanctum |
| GET | `/user` | `Api\V1\Auth\AuthenticatedSessionController@show` | auth:sanctum |
| PUT | `/profile` | `Api\V1\ProfileController@update` | auth:sanctum |
| GET/POST/GET/DELETE | `/categories` | `Api\V1\CategoryController` (apiResource) | auth:sanctum + role:admin |
| GET/PUT/DELETE | `/users` | `Api\V1\UserController@index/show/update/destroy` | auth:sanctum + role:admin |

---

## All Models

### `User`
- **Traits**: `HasApiTokens` (Sanctum), `HasFactory`, `Notifiable`
- **Fillable**: `name`, `email`, `password`
- **Hidden**: `password`, `remember_token`
- **Casts**: `email_verified_at => datetime`, `password => hashed`
- **Relations**: `roles()` BelongsToMany Role
- **Methods**: `hasRole()`, `hasAnyRole()`, `assignRole()`, `removeRole()`

### `Role`
- **Traits**: `LogsActivity`
- **Fillable**: `name`, `slug`, `description`
- **Relations**: `users()` BelongsToMany User
- **Methods**: `hasUser()`

### `Category`
- **Traits**: `HasFactory`, `SoftDeletes`, `HasMedia`, `HasTags`, `LogsActivity`
- **Fillable**: `name, slug, description, body, image, is_active, sort_order, published_at, unpublish_at, created_by, updated_by`
- **Casts**: `is_active => boolean`, `sort_order => integer`, `published_at => datetime`, `unpublish_at => datetime`
- **Scopes**: `published()` (active by schedule), `scheduled()` (future publish), `expiring()` (past unpublish)
- **Accessors**: `isPublished` (checks schedule), `imageUrl` (asset URL)
- **Relations**: `createdBy()`, `updatedBy()` BelongsTo User
- **Boot**: auto-slugs, sets `created_by`/`updated_by` from auth

### `Contact`
- **Traits**: `HasFactory`
- **Fillable**: `name, email, subject, message, ip_address, status`

### `Media`
- **Fillable**: `mediable_type, mediable_id, name, original_name, mime_type, size, path, disk, created_by`
- **Relations**: `mediable()` MorphTo, `createdBy()` BelongsTo User
- **Accessors**: `url`, `sizeFormatted`
- **Methods**: `isImage()`, `isPdf()`, `isExcel()`

### `Setting`
- **Fillable**: `group, key, value, type`
- **Statics**: `get(key, default)` cached, `set(key, value, type)`, `group(name)`

### `Subscriber`
- **Fillable**: `email, name, subscribed_at, unsubscribed_at, ip_address`
- **Casts**: `subscribed_at => datetime`, `unsubscribed_at => datetime`
- **Scopes**: `active()`
- **Methods**: `isActive()`

### `Tag`
- **Fillable**: `name, slug, color`
- **Relations**: `categories()` MorphToMany (taggable)
- **Boot**: auto-slugs

### `ActivityLog`
- **Fillable**: `user_id, event, auditable_type, auditable_id, old_values, new_values, ip_address, user_agent`
- **Casts**: `old_values => array`, `new_values => array`
- **Relations**: `user()` BelongsTo(User), `auditable()` MorphTo
- **Statics**: `log(event, model, oldValues, newValues)`


---

## All Services

### `CategoryService`
- `getPaginated(filters, perPage)` — search + active filter
- `getAll()` — active categories ordered
- `getById(id)` — with relations
- `create(data)` — auto-sets `is_active = false` if `published_at` is future
- `update(category, data)` — same future-date logic
- `delete(category)` — soft delete
- `restore(id)`, `forceDelete(id)`, `count()`


### `FileUploadService`
- Handles file upload, Media record creation, file type validation
- Constants: `FILE_TYPES` with limits (images 5MB, docs 10MB, spreadsheets 10MB)

### `ModuleRegistry`
- Auto-discovers admin controllers for reference (not used for access control)
- `getGroupedPermissions()` returns permissions grouped by module name (legacy, kept for reference)

---

## All Traits

### `HasRoles` (on User — inline, not a separate trait)
- `roles()` BelongsToMany, `hasRole()`, `assignRole()`, `removeRole()`

### `HasMedia` (on any model)
- `media()` MorphMany, `addMedia()`, `addMediaFromRequest()`, `getFirstMedia()`, `getImages()`, `clearMedia()`, `removeMedia()`

### `HasTags` (on any model)
- `tags()` MorphToMany, `attachTags()`, `detachTags()`, `syncTags()` (auto-creates new tags by name)

### `HasAuditColumns`
- Auto-sets `created_by`/`updated_by` on creating/updating

### `HasSlug`
- Auto-generates slug from `name` on create/update

### `LogsActivity`
- Boot trait: logs `created`, `updated`, `deleted` events to `ActivityLog`

---

## All Middleware

| Middleware | Alias | Purpose |
|-----------|-------|---------|
| `app/Middleware/RoleMiddleware` | `role` | Checks role slug |
| `app/Http/Middleware/IpRestrictionMiddleware` | `ip-restrict` | Whitelist IPs (wildcard/CIDR), allows all when whitelist empty |
| `app/Http/Middleware/MaintenanceModeMiddleware` | — | Global, checks DB setting, allows admins + bypass routes + health check, shows 503 |

---

## All Notifications

### `ContactFormNotification`
- **Channels**: `mail`, `database`
- **Constructor**: name, email, subject, message
- **toMail**: Full message with link to admin contacts
- **toArray**: `{title, body, type: 'contact_message', action_url}`
- **NOT queued** (runs synchronously)

### `WelcomeNotification`
- **Channels**: `mail`, `database`
- **Queued** (implements ShouldQueue with database queue)
- **Not currently dispatched anywhere**

---

## All Form Requests

### `CategoryRequest`
- Validates name, slug (unique, alpha_dash), description, image (5MB), attachments (10MB each, max 10 files), is_active (boolean), sort_order (min:0), published_at (date), unpublish_at (date, after:published_at)

### `ProfileUpdateRequest`
- Validates name (max:255), email (unique, lowercase)

### `Auth\LoginRequest`
- Validates email, password
- Handles authentication with rate limiting (5 attempts per email+IP)

---

## Admin Controller Methods & Features

| Controller | Methods | Notable Details |
|-----------|---------|----------------|
| `CategoryController` | CRUD + trashed/restore/forceDelete | Image upload, multiple attachments, media management |
| `UserController` | index/show/edit/update/destroy | Role assignment in edit, self-deletion blocked |
| `ContactController` | index/show/destroy | Auto-marks as read on view, search + status filter + date range, stats |
| `SubscriberController` | index/destroy/export | CSV export respects filters, status filter + date range + stats |
| `ActivityLogController` | index/export/destroy | CSV export preserves filters, event filter + date range + stats |
| `NotificationController` | index/read/read-all/destroy | All/Unread filter, per-notification actions |
| `HealthController` | index | DB, cache, queue, disk, PHP/Laravel version checks |
| `MaintenanceController` | index/toggle/message/bypass | DB-backed maintenance mode |
| `SessionController` | index/destroy | Cannot revoke own session |
| `IpRestrictionController` | index/update | Wildcard and CIDR support |
| `LogViewerController` | index/clear/download | Tail last 200 lines |
| `BackupController` | index/create/download/destroy | PostgreSQL SQL dumps (TRUNCATE + INSERT) |
| `RoleController` | CRUD (no show) | Role management (name, slug, description) |
| `TagController` | CRUD (no show) | Color picker, polymorphic tagging |
| `SettingController` | index/update/store/destroy | Grouped by General/SEO/Social/Mail — SMTP config, multiple from-addresses |
| `MediaController` | index/store/destroy | Search, MIME filter, thumbnails |

---

## Admin Views: Filter & Stats Patterns

All admin index pages follow a consistent pattern:
- **Stats cards** (row of colored left-border cards): Total, key breakdowns
- **Filter row** (card with form): search input, filter dropdown(s), date range, submit/reset buttons
- **Table** (card with responsive table): striped rows, action buttons (icon-only)
- **Pagination** in card footer

Pages with full filter+stats treatment:
- **Subscribers**: Total / Active / Unsubscribed stats; search + status + date range
- **Contacts**: Total / New / Read / Replied stats; search + status + date range
- **Users**: Total / Admins / Verified stats; search + role filter
- **Activity Logs**: Total / Today / Event Breakdown stats; search + event + date range
- **Tags**: Total Tags / Categories Tagged; search + reset button

---

## Scheduled Publishing System

- **Command**: `app:process-scheduled-publishing`
- **Schedule**: runs every minute via Laravel scheduler (defined in `bootstrap/app.php`)
- **Logic**: Sets `is_active = true` when `published_at <= now()` AND `is_active = false`; sets `is_active = false` when `unpublish_at <= now()` AND `is_active = true`
- **CategoryService**: auto-sets `is_active = false` when `published_at` is a future date (prevents immediate activation)
- **Scheduler must be running** — in dev via `schedule:work` (in `composer dev`), in prod via cron: `* * * * * cd /project && php artisan schedule:run >> /dev/null 2>&1`

---

## Composer Dev Script

`composer dev` runs concurrently:
1. `php artisan serve` — dev server
2. `php artisan queue:listen --tries=1 --timeout=0` — queue worker
3. `php artisan schedule:work` — scheduler (runs every minute)
4. `php artisan pail --timeout=0` — log watcher
5. `npm run dev` — Vite HMR

---

## Database Migrations (18 tables)

1. `users` — id, name, email, password, remember_token, timestamps
2. `cache` — key, value, expiration
3. `jobs` — id, queue, payload, attempts, reserved_at, available_at, created_at
4. `roles` — id, name, slug, description, timestamps
5. `role_user` — user_id, role_id (pivot)
6. `categories` — id, name, slug, description, body, image, is_active (default true), sort_order, published_at (nullable), unpublish_at (nullable), created_by, updated_by, timestamps, soft_deletes
7. `personal_access_tokens` — Sanctum tokens
8. `contacts` — id, name, email, subject, message, ip_address, status (default 'new'), timestamps
9. `media` — polymorphic (mediable_type, mediable_id nullable), name, original_name, mime_type, size, path, disk, created_by, timestamps
10. `settings` — id, group, key (unique), value, type, timestamps
11. `tags` — id, name, slug, color, timestamps
12. `taggables` — tag_id, taggable_id, taggable_type (pivot)
13. `activity_logs` — id, user_id (nullable), event, auditable_type, auditable_id, old_values (json), new_values (json), ip_address, user_agent, timestamps
14. `notifications` — id (uuid), type, notifiable_type, notifiable_id, data (json), read_at (nullable), timestamps
16. `subscribers` — id, email (unique), name (nullable), subscribed_at, unsubscribed_at (nullable), ip_address (nullable), timestamps
17. `sessions` — id, user_id, ip_address, user_agent, payload, last_activity
18. `cache` — key, value, expiration
19. `failed_jobs` — id, uuid, connection, queue, payload, exception, failed_at

---

## Seeders

- `DatabaseSeeder`: calls RoleSeeder, CategorySeeder, SettingsSeeder; creates admin/user accounts
- **Default admin**: `admin@example.com` / `password` (role: admin)
- **Default user**: `user@example.com` / `password` (role: user)
- **Categories seeded**: Technology, Business, Healthcare, Education, Finance
- **Settings seeded**: 14 defaults across general (app name, description, email, etc.), SEO (title, description, keywords), social (Facebook, Twitter, Instagram, LinkedIn), + 9 mail settings (driver, host, port, username, password, encryption, from address/name, additional from-addresses)

---

## Blade Layout Structure

- `layouts/app.blade.php` — Main admin layout: `@include('layouts.sidebar')` + `@include('layouts.topbar')` + `@include('partials/command-palette')` + `x-flash-message` + `{{ $slot }}`
- `layouts/guest.blade.php` — Auth pages layout (login, register, etc.)
- `layouts/sidebar.blade.php` — Dark sidebar with app logo, navigation links (role-gated), user info footer
- `layouts/topbar.blade.php` — Horizontal bar with search button (Ctrl+K), notification bell with unread badge + dropdown, user dropdown
- `partials/command-palette.blade.php` — Ctrl+K modal with search, keyboard navigation (arrows, Enter, Esc)
- `partials/public-navbar.blade.php` — Shared public navbar (Home, About, Services, Contact)
- `partials/public-footer.blade.php` — Shared public footer (About, Services, Contact links)
- `partials/newsletter-form.blade.php` — Email subscription form

---

## Components Reference

### Blade Components (`resources/views/components/`)
`application-logo`, `auth-session-status`, `danger-button`, `dropdown`, `dropdown-link`, `flash-message`, `input-error`, `input-label`, `modal`, `nav-link`, `primary-button`, `responsive-nav-link`, `secondary-button`, `text-input`, `tinymce` (Quill WYSIWYG editor — MIT licensed, free for commercial use)

### PHP View Components (`app/View/Components/`)
`AppLayout` → `layouts.app`, `GuestLayout` → `layouts.guest`

---

## Helper Functions (`app/Helpers/helpers.php`)
- `generate_slug(string)` — URL-safe slug
- `format_date($date, format)` — Carbon formatting
- `time_ago($date)` — Human-readable relative time
- `get_initials(string)` — First 2 uppercase initials
- `truncate_text(string, length)` — Truncate with ellipsis

---

## Key Architectural Decisions

1. **RBAC over single-role**: Users can have multiple roles, admin role gives full access to admin panel
2. **DB-backed settings**: Instead of `.env` for everything, admin-configurable settings live in the DB with caching
3. **Polymorphic media/tags/activity**: Media, tags, and activity logs use polymorphic relationships for reuse across models
4. **Soft deletes + recycle bin**: Categories use soft deletes with dedicated restore/force-delete UI
6. **Scheduled publishing**: Categories can be scheduled for future publish/unpublish, processed by a cron-driven artisan command every minute
7. **Synchronous notifications**: Contact form notifications are NOT queued (to ensure immediate in-app delivery without a running queue worker)
8. **IP whitelist middleware**: Applied to all admin routes, supports exact IP, CIDR, and wildcard patterns
9. **Starter kit philosophy**: Features are self-contained and can be disabled by removing the route/controller without breaking the rest

---

## Common Task References

**Creating a new admin CRUD page**:
1. Create migration for the table
2. Create Model with fillable, casts, traits, scopes
3. Create Controller in `Admin/` with index/create/store/show/edit/update/destroy
4. Create FormRequest for validation
5. Add route in `routes/admin.php`
6. Create views in `resources/views/admin/{name}/`
7. Add sidebar link in `layouts/sidebar.blade.php`

**Adding a public page**:
1. Create view in `resources/views/public/`
2. Add route in `routes/public.php`
3. Include `partials.public-navbar` and `partials.public-footer`

**Creating a new API endpoint**:
1. Create controller in `Api/V1/`
2. Add route in `routes/api.php`
3. Create JSON Resource if custom response format needed

**Adding a new notification**:
1. Create notification class in `app/Notifications/`
2. Define `via()`, `toMail()`, `toArray()`
3. Dispatch: `$user->notify(new Notification(...))`
4. Don't implement `ShouldQueue` unless you run queue worker

**Adding a new admin filter+stat page**:
1. Controller: compute `$stats` array, apply search/filter/date-range to query, pass to view
2. View: stats cards row (colored left-border cards), filter form with search/dropdown/date range/clear button, responsive table, pagination
