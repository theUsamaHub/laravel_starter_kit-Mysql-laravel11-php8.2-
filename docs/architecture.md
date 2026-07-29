# Architecture

## Directory Structure

```
app/
├── Console/Commands/         # Artisan commands (scheduled publishing, etc.)
├── Helpers/                  # Global helper functions (helpers.php)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # Admin panel controllers (fully CRUD)
│   │   ├── Api/V1/           # REST API controllers
│   │   └── (Auth/)           # Breeze auth controllers
│   ├── Middleware/            # Custom middleware (permission, role, IP restrict, maintenance)
│   ├── Requests/              # Form request validation classes
│   └── Resources/             # API JSON resources
├── Models/                    # Eloquent models (19 total)
├── Notifications/             # Notification classes
├── Providers/                 # Service providers (MailConfig, etc.)
├── Services/                  # Business logic layer
├── Traits/                    # Reusable traits (HasRoles, HasMedia, HasTags, etc.)
└── View/Components/           # Blade view components

resources/
├── views/
│   ├── admin/                 # All admin panel views (per module)
│   ├── components/            # Blade components
│   ├── layouts/               # App layout, sidebar, topbar, guest layout
│   ├── partials/              # Shared partials (navbar, footer, newsletter, command palette)
│   ├── public/                # Public page views (about, services, contact, pricing)
│   ├── profile/               # Profile pages
│   └── (auth/)                # Auth pages (Breeze)
├── css/app.scss               # Bootstrap 5 SCSS entry point
└── js/app.js                  # Alpine.js + Bootstrap JS entry point

routes/
├── web.php                    # Web routes (home, dashboard, contact store)
├── auth.php                   # Auth routes (login, register, password reset, verification)
├── admin.php                  # Admin panel routes (prefix /admin)
├── public.php                 # Public page routes (/about, /services, /contact, /pricing)
└── api.php                    # API v1 routes (prefix /api/v1)
```

## Design Pattern

### Service Layer
Business logic lives in `app/Services/`, not in controllers. Controllers are thin — they validate input, call a service method, and return a response.

```php
// Controller — thin
class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService) {}

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getPaginated($request->only(['search', 'is_active']));
        return view('admin.categories.index', compact('categories'));
    }
}
```

### Traits
Reusable behaviour is extracted into traits under `app/Traits/`:

| Trait | Purpose |
|-------|---------|
| `HasRoles` | Role assignment, checking, removal (BelongsToMany) |
| `HasMedia` | Polymorphic media attachments |
| `HasTags` | Polymorphic tagging |
| `HasSlug` | Auto-generate URL slugs from name |
| `HasAuditColumns` | Auto-set created_by / updated_by |
| `LogsActivity` | Auto-log create/update/delete events |

### Form Requests
Validation for admin CRUD operations uses dedicated Form Request classes in `app/Http/Requests/`. These can merge with dynamic validation rules from the database via `ValidationRule` model.

## Route Groups

| Group | Prefix | Middleware | Purpose |
|-------|--------|-----------|---------|
| Web | `/` | `web` | Home, public pages |
| Auth | — | `guest` or `auth` | Login, register, password |
| Admin | `/admin` | `auth, verified, role:admin, ip-restrict` | Admin panel |
| Public | — | `web` | About, services, contact, pricing |
| API | `/api/v1` | `api` | REST endpoints, Sanctum auth |

## Key Design Decisions

### RBAC over single-role
Users can have multiple roles. Each role stores its permissions as a JSON array. Admin role bypasses all permission checks.

### DB-backed settings
Instead of .env-only, admin-configurable settings live in the `settings` table with caching. The `MailConfigServiceProvider` overrides mail config from DB at runtime.

### Polymorphic relationships
Media, tags, and activity logs use polymorphic relationships so any model can use them without schema changes.

### Scheduled publishing
Categories support `published_at` / `unpublish_at` dates. An artisan command (`app:process-scheduled-publishing`) runs every minute to activate/deactivate them.
