# Laravel Starter Kit

A production-ready Laravel 13 starter kit built with Bootstrap 5, Sanctum, and clean architecture principles. Designed to evolve into any application: HR, CRM, ERP, E-Commerce, Booking Systems, and more.

## Tech Stack

- **PHP** 8.3+
- **Laravel** 13
- **MySQL** (configurable)
- **Bootstrap** 5.3
- **Vite** 8
- **Laravel Breeze** (authentication)
- **Laravel Sanctum** (API tokens)

## Requirements

- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8.0+

## Installation

```bash
# Clone the repository
git clone <repo-url>
cd Laravel_Starter_Kit

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure .env with your database credentials

# Run migrations and seeders
php artisan migrate --seed

# Build assets
npm run build

# Start development server
php artisan serve
```

## Default Credentials

| Role  | Email            | Password |
|-------|------------------|----------|
| Admin | admin@example.com| password |
| User  | user@example.com | password |

## Architecture

```
app/
├── Actions/          # Single-purpose action classes
├── Console/          # Artisan commands
├── Events/           # Event classes
├── Exceptions/       # Exception handling
├── Helpers/          # Global helper functions
├── Http/
│   ├── Controllers/
│   │   ├── Admin/    # Admin panel controllers
│   │   ├── Api/V1/   # API v1 controllers
│   │   └── Auth/     # Breeze auth controllers
│   ├── Middleware/    # Custom middleware
│   ├── Requests/     # Form request validation
│   └── Resources/    # API resources
├── Listeners/        # Event listeners
├── Mail/             # Mailable classes
├── Models/           # Eloquent models
├── Notifications/    # Notification classes
├── Observers/        # Model observers
├── Policies/         # Authorization policies
├── Providers/        # Service providers
├── Repositories/     # Repository pattern
├── Rules/            # Custom validation rules
├── Services/         # Business logic layer
├── Support/          # Support utilities
├── Traits/           # Reusable traits
└── View/Components/  # Blade view components
```

## Routes

### Web Routes (`routes/web.php`)
- `/` - Home page
- `/dashboard` - Authenticated dashboard

### Auth Routes (`routes/auth.php`)
- `/login`, `/register`, `/forgot-password`, `/reset-password`
- `/verify-email`, `/confirm-password`, `/logout`

### Admin Routes (`routes/admin.php`)
- `/admin` - Admin dashboard
- `/admin/categories` - Category CRUD

### API Routes (`routes/api.php`)
- `POST /api/v1/auth/register` - Register
- `POST /api/v1/auth/login` - Login
- `POST /api/v1/auth/logout` - Logout
- `GET /api/v1/user` - Current user
- `PUT /api/v1/profile` - Update profile
- `GET|POST|PUT|DELETE /api/v1/categories` - Category CRUD

### Public Routes (`routes/public.php`)
- `/about`, `/services`, `/contact`

## Role-Based Access Control (RBAC)

| Role  | Access |
|-------|--------|
| Admin | Full system access, admin panel |
| User  | Dashboard, profile, own resources |

## Adding a New Module

1. Create migration: `php artisan make:migration create_<table>_table`
2. Create model: `php artisan make:model <Model> -mf`
3. Create service: `app/Services/<Model>Service.php`
4. Create controller: `app/Http/Controllers/Admin/<Model>Controller.php`
5. Create form request: `app/Http/Requests/<Model>Request.php`
6. Create views: `resources/views/admin/<models>/`
7. Add routes in `routes/admin.php`
8. Add API routes in `routes/api.php`
9. Create API resource: `app/Http/Resources/<Model>Resource.php`
10. Seed data: `database/seeders/<Model>Seeder.php`

## Design Tokens

CSS custom properties in `resources/css/app.scss`:
- `--bs-primary`: Primary brand color (#4f46e5)
- `--bs-link-color`: Link color
- `--bs-body-font-family`: Body font

## Contributing

Follow PSR-12 coding standards. Use Laravel Pint for formatting:
```bash
./vendor/bin/pint
```

## License

MIT License.
