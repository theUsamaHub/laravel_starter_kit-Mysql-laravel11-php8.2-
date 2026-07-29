# Customization

## Changing Brand Colors

Edit `resources/css/app.scss`:

```scss
// Change the primary color
$primary: #4f46e5;  // ← Replace with your brand color
```

Then rebuild: `npm run build`

The sidebar background, topbar, buttons, badges, and link colors all derive from `$primary`.

## Site Name & Logo

### Name
```env
APP_NAME=YourBrandName
```

### Logo
Replace the `x-application-logo` component in `resources/views/components/application-logo.blade.php`. You can use an SVG, image, or text.

## Adding a New Admin Module

### 1. Create migration
```bash
php artisan make:migration create_projects_table
```

Example migration:
```php
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->foreignId('created_by')->nullable()->constrained('users');
    $table->foreignId('updated_by')->nullable()->constrained('users');
    $table->timestamps();
});
```

### 2. Create model
```bash
php artisan make:model Project
```

Use available traits as needed:
```php
class Project extends Model
{
    use \App\Traits\HasSlug;
    use \App\Traits\HasAuditColumns;
    use \App\Traits\HasMedia;
    use \App\Traits\HasTags;
    use \App\Traits\LogsActivity;

    protected $fillable = ['name', 'slug', 'description', 'is_active', 'sort_order', 'created_by', 'updated_by'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];
}
```

### 3. Create Controller
```bash
php artisan make:controller Admin/ProjectController
```

Copy pattern from an existing controller like `CategoryController`:
```php
class ProjectController extends Controller
{
    public function index(Request $request): View { /* ... */ }
    public function create(): View { /* ... */ }
    public function store(ProjectRequest $request): RedirectResponse { /* ... */ }
    public function show(Project $project): View { /* ... */ }
    public function edit(Project $project): View { /* ... */ }
    public function update(ProjectRequest $request, Project $project): RedirectResponse { /* ... */ }
    public function destroy(Project $project): RedirectResponse { /* ... */ }
}
```

### 4. Create Form Request
```bash
php artisan make:request ProjectRequest
```

### 5. Create views

Create `resources/views/admin/projects/` with:
- `index.blade.php` — List with search, filters, pagination
- `create.blade.php` — Create form
- `edit.blade.php` — Edit form (extend create)
- `show.blade.php` — Detail view

### 6. Add routes
In `routes/admin.php`:
```php
Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
```

### 7. Add sidebar link
In `resources/views/layouts/sidebar.blade.php`, add:
```blade
<li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}"><i class="bi bi-folder"></i> {{ __('Projects') }}</a></li>
```

The module will be auto-discovered by `ModuleRegistry` and permissions will be generated automatically.

## Adding a New Public Page

### 1. Create the view
```blade
{{-- resources/views/public/faq.blade.php --}}
@extends('layouts.public')
@section('content')
    <h1>FAQ</h1>
    <!-- your content -->
@endsection
```

Including navbar and footer:
```blade
@include('partials.public-navbar')
<!-- your content -->
@include('partials.public-footer')
```

### 2. Add route
In `routes/public.php`:
```php
Route::get('/faq', function () {
    return view('public.faq');
})->name('public.faq');
```

### 3. Add navigation link
In `resources/views/partials/public-navbar.blade.php`:
```blade
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('public.faq') ? 'active' : '' }}" href="{{ route('public.faq') }}">FAQ</a>
</li>
```

## Adding a New API Endpoint

### 1. Create controller
```bash
php artisan make:controller Api/V1/ProjectController
```

### 2. Add route
In `routes/api.php`:
```php
Route::apiResource('projects', \App\Http\Controllers\Api\V1\ProjectController::class)
    ->middleware('auth:sanctum');
```

### 3. Create JSON Resource (optional)
```bash
php artisan make:resource ProjectResource
```

## Email Configuration

SMTP settings can be managed directly from the admin panel at `/admin/settings` → Mail section. No .env editing needed for:

- Driver (log/smtp/ses/postmark/mailgun)
- Host, port, username, password
- Encryption (none/tls/ssl)
- From address and name
- Multiple additional from-addresses

These override `config/mail.php` at runtime via `MailConfigServiceProvider`.

## Adding New Settings

Settings are created dynamically via the admin panel at `/admin/settings`. Supported types:
- `text`, `textarea`, `number`, `boolean`, `image`, `json`

To access a setting in code:
```php
$value = Setting::get('your_key', 'default_value');
```

To set programmatically:
```php
Setting::set('your_key', 'your_value', 'text');
```
