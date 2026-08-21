# Laravel Starter Kit

A production-ready Laravel 11 starter kit with 17+ admin modules, RBAC, REST API, Bootstrap 5, and clean architecture. Scales from side projects to enterprise systems.

## What's Included

- **Full Admin Panel** — Dashboard, Categories (CRUD + Soft Deletes + Media + Tags), Users, Roles, Media Library, Tags, Contacts, Subscribers, Settings, Activity Logs, Notifications, Sessions, IP Restrictions, Maintenance Mode, Health Dashboard, Log Viewer, Database Backup
- **RBAC** — Role-based access control (admin/user) with middleware enforcement
- **REST API v1** — Sanctum token auth, register/login/logout, CRUD for categories & users, JSON Resources, health check
- **Public Pages** — Welcome, About, Services, Pricing, Contact (with form)
- **Authentication** — Web (Breeze) + API (Sanctum), email verification, password reset, rate limiting
- **In-App Notifications** — Bell dropdown with unread badge, email + database channels
- **SMTP Config from Admin** — No .env editing needed for mail settings
- **Database Backups** — MySQL dumps from admin UI
- **Performance Optimized** — Cached settings, eager-loaded relationships, aggregated queries
- **Bootstrap 5 + Alpine.js** — Responsive UI, dark sidebar, command palette (Ctrl+K)
- **Newsletter Subscription** — Subscribe form on welcome page, subscriber management in admin

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
- **MySQL** (primary) / **SQLite** (tests)
- **Bootstrap 5.3** + **Bootstrap Icons** — SCSS build via Vite
- **Alpine.js** — Frontend interactivity
- **Vite 8** — Build tool with HMR
- **Laravel Sanctum** — API token auth
- **Database Queue** — Default queue driver
- **Quill Editor** — MIT-licensed WYSIWYG

## License

This is a commercial product. See LICENSE file for details.
