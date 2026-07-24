# Laravel Starter Kit - AI Context File

> This file provides persistent context for AI models working on this project.

## Project Overview

Production-ready Laravel 13 starter kit with Bootstrap 5, Alpine.js, and PostgreSQL. Designed to be reused for hackathons, competitions, client projects, SaaS products, and business management systems. Includes full admin panel, REST API with Sanctum, file uploads, dynamic validation, and maintenance mode.

## Tech Stack

- PHP 8.5.8
- Laravel 13.18.0
- PostgreSQL (not MySQL) — host=127.0.0.1:5432, db=laravel_starter, user=postgres, password=Falcon47#
- Bootstrap 5.3 (SCSS compiled via Vite)
- Bootstrap Icons
- Alpine.js (installed via npm, used for modals, flash messages, interactive UI)
- Laravel Breeze (Blade stack)
- Laravel Sanctum (API tokens)
- Vite 8 (asset bundling)
- Docker (multi-container: app, nginx, postgres, redis, node, queue, scheduler)

## Docker

### Services (7 containers)
- **app** — PHP 8.3-FPM + Laravel (main application)
- **nginx** — Nginx web server (reverse proxy to app:9000)
- **postgres** — PostgreSQL 16 (database)
- **redis** — Redis 7 (cache, queue, sessions)
- **node** — Node 20 (Vite dev server)
- **queue** — Laravel queue worker
- **scheduler** — Laravel task scheduler

### Quick Start
```bash
# First time setup
cp .env.docker .env
docker compose up -d
docker compose exec app php artisan migrate:fresh --seed --force

# Or use Makefile
make up          # Start containers
make fresh       # Migrate + seed
make logs        # View logs
make shell       # Shell into app
make destroy     # Remove everything
```

### Docker Commands
```bash
docker compose up -d              # Start all containers
docker compose down               # Stop all containers
docker compose exec app sh        # Shell into app
docker compose exec app php artisan ...  # Run artisan
docker compose logs -f            # View logs
docker compose build --no-cache   # Rebuild containers
```

### Ports
- App/Nginx: 8000 (configurable via APP_PORT)
- PostgreSQL: 5432
- Redis: 6379
- Node (Vite): 5173

### Files
- `Dockerfile` — Multi-stage build (Node → Composer → PHP-FPM)
- `docker-compose.yml` — 7 services with health checks
- `docker/nginx/app.conf` — Nginx config with gzip, caching, security headers
- `docker/php/php.ini` — PHP config (256M memory, 20M uploads, opcache)
- `docker/php/www.conf` — PHP-FPM pool (20 workers, slow log)
- `docker/scripts/entrypoint.sh` — Startup script (migrate, seed, cache)
- `docker/scripts/supervisord.conf` — Process manager
- `.env.docker` — Docker environment template
- `.dockerignore` — Excludes vendor, node_modules, .env
- `Makefile` — 16 easy commands

## Shell Execution

- Use `cmd /c "php artisan ..."` for PHP commands (PowerShell blocks npm scripts directly)
- Use `cmd /c "npm run build"` for asset builds
- MySQL is NOT installed; PostgreSQL is the database

## Architecture Decisions

- **Thin controllers** — All business logic in Services
- **Service layer** — CategoryService, FileUploadService, DynamicValidationService as blueprints
- **Form Requests** — Dedicated validation classes per module, with dynamic rule merging from DB
- **API Resources** — Never return raw models from API
- **RBAC** — Role-based access via `role_user` pivot table (custom, no Spatie)
- **Soft deletes** — Categories use SoftDeletes trait
- **Audit columns** — `created_by`, `updated_by` on all modules
- **Auto-slug** — Categories auto-generate slugs from names
- **Versioned API** — All API routes under `/api/v1/`
- **Media/Attachments** — Polymorphic HasMedia trait on Category, supports images/PDFs/Excel
- **Dynamic Validation** — Rules stored in DB, merged with hardcoded rules at runtime
- **Site Settings** — Cache-backed key-value store with typed fields
- **Maintenance Mode** — Cache-based toggle, admin bypass, custom 503 page

## Folder Structure

```
app/
├── Http/Controllers/
│   ├── Admin/                  # Admin panel controllers
│   │   ├── CategoryController.php
│   │   ├── ContactController.php
│   │   ├── MaintenanceController.php
│   │   ├── MediaController.php
│   │   ├── SettingController.php
│   │   ├── UserController.php
│   │   └── ValidationRuleController.php
│   ├── Api/V1/                 # Versioned API controllers
│   │   ├── Auth/AuthenticatedSessionController.php
│   │   ├── Auth/RegisteredUserController.php
│   │   ├── CategoryController.php
│   │   ├── ProfileController.php
│   │   └── UserController.php
│   ├── Auth/                   # Breeze auth controllers (7 files)
│   ├── ContactController.php   # Public contact form handler
│   └── ProfileController.php   # User profile management
├── Http/Requests/
│   ├── CategoryRequest.php     # Merges hardcoded + dynamic DB rules
│   ├── ProfileUpdateRequest.php
│   └── Auth/LoginRequest.php
├── Http/Resources/
│   ├── CategoryResource.php    # Includes media array
│   └── UserResource.php
├── Middleware/
│   ├── RoleMiddleware.php      # Non-standard path (App\Middleware)
│   └── MaintenanceModeMiddleware.php
├── Models/
│   ├── Category.php            # HasMedia, SoftDeletes, auto-slug
│   ├── Contact.php             # Contact form submissions
│   ├── Media.php               # Polymorphic file attachments
│   ├── Role.php
│   ├── Setting.php             # Cache-backed key-value store
│   ├── User.php                # Has roles, HasApiTokens
│   └── ValidationRule.php      # Dynamic validation rules
├── Services/
│   ├── CategoryService.php
│   ├── DynamicValidationService.php
│   └── FileUploadService.php
└── Traits/
    └── HasMedia.php            # Polymorphic media trait
```

## Route Files

- `routes/web.php` — Dashboard, profile, contact form POST
- `routes/auth.php` — Breeze authentication (loaded via `then` callback with web middleware)
- `routes/admin.php` — Full admin panel (role:admin middleware)
- `routes/api.php` — Versioned REST API with Sanctum
- `routes/public.php` — Public pages (about, services, contact)

### All Route Groups (59+ routes)
- Web: home, dashboard, profile (edit/update/destroy), contact.store
- Auth: login, register, logout, password reset, email verification
- Admin: dashboard, categories CRUD, users (index/show/edit/update/destroy), contacts (index/show/destroy), maintenance (toggle/message), media (index/store/destroy), validation-rules CRUD, settings (index/update/store/destroy)
- API: health, auth (register/login/logout), user, profile.update, categories CRUD (admin), users CRUD (admin)
- Public: about, services, contact

## Key Models

### User
- Has roles (belongsToMany Role)
- Has API tokens (Sanctum)
- Uses PHP 8 attributes: `#[Fillable]`, `#[Hidden]`
- Methods: `hasRole()`, `hasAnyRole()`, `assignRole()`, `removeRole()`
- **Important**: `assignRole()` uses `$this->roles->contains()` (collection), NOT `$this->roles()->contains()` (query builder)

### Category
- Has HasMedia trait — polymorphic file attachments
- Fields: name, slug, description, image, is_active, sort_order, created_by, updated_by
- Soft deletes
- Audit: created_by, updated_by (guarded with `auth()->id() ?? $category->updated_by`)
- Auto-slug generation on create
- Slug regenerates on name change ONLY if slug is empty

### Media
- Polymorphic (morphTo mediable)
- Fields: name, original_name, mime_type, size, path, disk, created_by
- Helper methods: `isImage()`, `isPdf()`, `isExcel()`, `url`, `size_formatted`

### ValidationRule
- Fields: form_name (unique), rules (JSON), custom_messages (JSON)
- Static helpers: `getRules($formName)`, `getMessages($formName)`

### Setting
- Fields: group, key (unique), value, type (text/textarea/number/boolean/image/json)
- Cache-backed: `Setting::get($key)`, `Setting::set($key, $value, $type)`
- Groups: general, seo, social

### Contact
- Fields: name, email, subject, message, ip_address, status (new/read/replied)

## Database Schema (10 tables)

- `users` — Standard Laravel users + roles relationship
- `roles` — Role definitions (admin, user)
- `role_user` — Pivot table for user-role assignment
- `categories` — CRUD module with soft deletes, image, audit columns
- `contacts` — Contact form submissions with status workflow
- `media` — Polymorphic file attachments
- `validation_rules` — Dynamic validation rules per form
- `settings` — Site settings key-value store
- `personal_access_tokens` — Sanctum API tokens
- `sessions` — Database session driver

## Service Layer

- **CategoryService** — Paginated listing with filters, CRUD
- **FileUploadService** — File upload/delete/type detection (images, documents, spreadsheets)
- **DynamicValidationService** — Merges hardcoded rules with DB rules

## HasMedia Trait

```php
$category->addMedia($file);           // Upload file
$category->addMediaFromRequest('field'); // From request
$category->media;                     // All media
$category->getImages();               // Images only
$category->getFiles();                // Non-images
$category->getFirstMedia();           // Latest media item
$category->removeMedia($media);       // Delete one
$category->clearMedia();              // Delete all
```

## Dynamic Validation

Rules stored in `validation_rules` table. FormRequest classes merge them at runtime:
```php
$dynamicRules = ValidationRule::getRules('category');
$rules = array_merge($baseRules, $dynamicRules);
```

Admin can add/edit/delete rules via `/admin/validation-rules`.

## Admin Panel Features

- Dashboard with real-time stats (users, categories, contacts, roles)
- Category CRUD with image upload, attachments, soft deletes
- User management with role assignment
- Contact message management with status workflow
- Media library (browse, upload, filter, delete)
- Dynamic validation rules editor
- Site settings editor (grouped, typed fields)
- Maintenance mode toggle with custom message

## Sidebar Navigation

1. Dashboard
2. Profile
3. **Admin section** (role:admin only):
   - Admin Dashboard
   - Categories (with badge count)
   - Users
   - Contacts (with unread badge)
   - Media
   - Validation
   - Settings
   - Maintenance (with ON/OFF badge)

## Error Pages

Styled gradient pages for: 403, 404, 419 (CSRF expired), 429 (rate limit), 500, 503 (maintenance)
- Each has unique gradient, icon, contextual message
- Conditional links (Dashboard if logged in, Login if guest)
- 503 auto-refreshes every 30 seconds

## Flash Messages

`<x-flash-message />` component in app layout — auto-dismiss after 5s with Alpine.js
Supports: success, error, warning, info, validation errors

## API Response Format

```json
{
    "data": [...],
    "links": {...},
    "meta": {...}
}
```

## Seeded Data

- 2 roles: admin, user
- 2 users: admin@example.com (admin), user@example.com (user) — password: `password`
- 5 categories: Technology, Business, Healthcare, Education, Finance
- 14 settings: site_name, site_description, contact_email, meta tags, social links
- 2 validation rules: contact_form, user_register

## Known Issues / Gotchas

- Bootstrap SCSS has deprecation warnings from Bootstrap's own code (not ours)
- Termwind `mb_strimwidth` incompatibility with PHP 8.5 — `php artisan migrate:fresh --seed` fails at seeding step; use `db:seed --class=X` individually
- `User::assignRole()` must use `$this->roles->contains()` (collection), NOT `$this->roles()->contains()` (query builder)
- `Category::updating` boot callback must guard `auth()->id() ?? $category->updated_by` to avoid null overwrite in CLI/queue contexts
- `$errors` variable only available in views when route files are wrapped in `web` middleware group
- RoleMiddleware is at `App\Middleware\RoleMiddleware` (not the standard `App\Http\Middleware` path)
- No queue workers configured for production
- No Redis/Memcached configuration (using database cache)

## AI Instructions

When working on this project:
1. Always check existing patterns in Category module before creating new modules
2. Follow the Service-Controller-Request-Resource pattern
3. Use Bootstrap 5 classes, never Tailwind
4. API responses must use JSON resources
5. All admin routes require `auth`, `verified`, `role:admin` middleware
6. Place business logic in Services, not Controllers
7. Use Form Requests for validation (with dynamic rule merging)
8. Keep controllers thin
9. Use `cmd /c` prefix for shell commands
10. Database is PostgreSQL, not MySQL
11. Use `updateOrCreate` in seeders to be idempotent
12. Guard `auth()->id()` with null coalesce in model boot callbacks
