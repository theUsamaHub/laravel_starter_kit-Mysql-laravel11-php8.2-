# Laravel Starter Kit

A production-ready Laravel 13 starter kit with 17+ admin modules, RBAC, REST API, Bootstrap 5, and clean architecture. Scales from side projects to enterprise systems.

## What's Included

- **Full Admin Panel** — Dashboard, Categories, Users, Roles & Permissions, Media Library, Tags, Contacts, Subscribers, Settings, Activity Logs, Notifications, Sessions, IP Restrictions, Maintenance Mode, Health Dashboard, Log Viewer, Database Backup, Dynamic Validation Rules
- **RBAC** — Role-based access control with auto-discovered permissions from admin controllers
- **REST API v1** — Sanctum auth, CRUD endpoints, JSON Resources
- **Public Pages** — Welcome, About, Services, Contact (with form), Pricing
- **Authentication** — Web (Breeze) + API (Sanctum), email verification, password reset, rate limiting
- **Scheduled Publishing** — Future publish/unpublish dates for content
- **In-App Notifications** — Bell dropdown with unread badge, email + database channels
- **SMTP Config from Admin** — No .env editing needed for mail settings
- **Database Backups** — PostgreSQL dumps from admin UI
- **Performance Optimized** — Cached settings, eager-loaded relationships, aggregated queries, 25+ DB indexes
- **Bootstrap 5 + Alpine.js** — Responsive UI, dark sidebar, command palette (Ctrl+K)

## Quick Start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
composer dev
```

Visit `http://localhost:8000` — login as `admin@example.com` / `password`.

## Full Documentation

See the [docs/](docs/) folder for complete guides:

| Document | Description |
|----------|-------------|
| [Getting Started](docs/getting-started.md) | Installation, requirements, first run |
| [Architecture](docs/architecture.md) | Directory structure, patterns, design decisions |
| [Admin Panel](docs/admin-panel.md) | Full admin module reference |
| [Customization](docs/customization.md) | Branding, new modules, public pages, API endpoints |
| [Development Guide](docs/development.md) | Services, traits, caching, coding standards |

## Tech Stack

- **Laravel 11** — PHP 8.2
- **Bootstrap 5.3** + **Bootstrap Icons** — SCSS build via Vite
- **Alpine.js** — Frontend interactivity
- **Vite 8** — Build tool with HMR
- **Laravel Sanctum** — API token auth
- **PostgreSQL** (primary) / **SQLite** (tests)
- **Database Queue** — Default queue driver
- **Quill Editor** — MIT-licensed WYSIWYG

## License

This is a commercial product. See LICENSE file for details.
