# Getting Started

## Requirements

- PHP 8.3+
- Composer 2.x
- Node.js 18+ with npm
- PostgreSQL 15+ (recommended) or MySQL 8.0+
- A queue driver (database is configured by default)

## Installation

```bash
# Clone the repository
git clone <your-repo-url>
cd Laravel_Starter_Kit

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env
#   DB_CONNECTION=pgsql
#   DB_HOST=127.0.0.1
#   DB_PORT=5432
#   DB_DATABASE=laravel_starter_kit
#   DB_USERNAME=postgres
#   DB_PASSWORD=

# Run migrations and seeders
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the development server
composer dev
```

The `composer dev` command runs five processes concurrently:
1. `php artisan serve` — Laravel dev server (port 8000)
2. `php artisan queue:listen` — Queue worker for queued jobs
3. `php artisan schedule:work` — Scheduler for publishing/unpublishing
4. `php artisan pail` — Log watcher
5. `npm run dev` — Vite HMR for frontend assets

## Default Credentials

| Role  | Email               | Password   |
|-------|---------------------|------------|
| Admin | admin@example.com   | password   |
| User  | user@example.com    | password   |

## Quick Start

1. Visit `http://localhost:8000` — public welcome page
2. Log in as `admin@example.com` / `password`
3. Navigate to `/admin` — full admin dashboard
4. Browse Users, Categories, Tags, Settings, and all modules

## Default Features Enabled

| Feature | Status |
|---------|--------|
| Authentication (login/register/reset) | Enabled |
| Email verification | Enabled (not strictly enforced) |
| Admin panel | Enabled at `/admin` |
| Roles & permissions | Pre-seeded (admin + user) |
| API (Sanctum) | Enabled at `/api/v1` |
| Queue (database) | Configured, worker runs with `composer dev` |
| Scheduler (publishing) | Configured, runs with `composer dev` |
| Maintenance mode | DB-backed (disabled by default) |
| IP restrictions | DB-backed (empty by default — all IPs allowed) |

## Running Tests

```bash
php artisan test
```

Tests use SQLite in-memory database so no additional setup is needed.
