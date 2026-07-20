# Laravel Starter Kit - AI Context File

> This file provides persistent context for AI models working on this project.

## Project Overview

Production-ready Laravel 13 starter kit with Bootstrap 5, designed to be reused for hackathons, competitions, client projects, SaaS products, and business management systems.

## Tech Stack

- PHP 8.3+ (currently 8.5.8)
- Laravel 13.8
- MySQL (configurable, default: laravel_starter)
- Bootstrap 5.3 (SCSS compiled via Vite)
- Bootstrap Icons
- Laravel Breeze (Blade stack)
- Laravel Sanctum (API tokens)
- Vite 8 (asset bundling)

## Architecture Decisions

- **Thin controllers** - All business logic in Services
- **Service layer** - CategoryService as blueprint for all modules
- **Form Requests** - Dedicated validation classes per module
- **API Resources** - Never return raw models from API
- **RBAC** - Role-based access via `role_user` pivot table
- **Soft deletes** - Categories use SoftDeletes trait
- **Audit columns** - `created_by`, `updated_by` on all modules
- **Auto-slug** - Categories auto-generate slugs from names
- **Versioned API** - All API routes under `/api/v1/`

## Folder Structure

```
app/
├── Helpers/helpers.php         # Global helper functions
├── Http/Controllers/
│   ├── Admin/                  # Admin panel controllers
│   ├── Api/V1/                 # Versioned API controllers
│   └── Auth/                   # Breeze auth controllers
├── Http/Requests/              # Form request validation
├── Http/Resources/             # API JSON resources
├── Middleware/RoleMiddleware.php
├── Models/                     # User, Role, Category
├── Services/                   # Business logic layer
├── Traits/                     # HasRoles, HasSlug, HasAuditColumns
```

## Route Files

- `routes/web.php` - Dashboard (authenticated)
- `routes/auth.php` - Breeze authentication
- `routes/admin.php` - Admin panel (role:admin middleware)
- `routes/api.php` - Versioned REST API
- `routes/public.php` - Public pages (about, services, contact)

## Key Models

### User
- Has roles (belongsToMany Role)
- Has API tokens (Sanctum)
- Methods: `hasRole()`, `hasAnyRole()`, `assignRole()`, `removeRole()`

### Role
- Fields: name, slug, description
- Seeders create: admin, user

### Category
- Fields: name, slug, description, is_active, sort_order
- Soft deletes
- Audit: created_by, updated_by
- Auto-slug generation

## Database Schema

- `users` - Standard Laravel users + roles relationship
- `roles` - Role definitions (admin, user)
- `role_user` - Pivot table for user-role assignment
- `categories` - Sample CRUD module with soft deletes
- `personal_access_tokens` - Sanctum API tokens

## Service Layer Rules

- Controllers MUST call Services, never Eloquent directly
- Services return Models, Collections, or LengthAwarePaginator
- Services handle business logic, filtering, pagination

## API Response Format

```json
{
    "data": [...],
    "links": {...},
    "meta": {...}
}
```

## UI Conventions

- Bootstrap 5 with custom CSS variables
- Sidebar + Topbar layout for admin
- Auth pages use centered card design
- Bootstrap Icons for all iconography
- Pagination uses Bootstrap 5 pagination component

## Coding Standards

- PSR-12 compliant
- Type hints on all methods
- Return types on all methods
- PHPDoc only when non-obvious
- No comments unless explaining WHY

## Pending Tasks

- [ ] Add more CRUD modules (Posts, Tags, etc.)
- [ ] Implement file upload system (FileUploadService)
- [ ] Add AI service placeholder
- [ ] Add notification system
- [ ] Add activity logging
- [ ] Add API rate limiting configuration
- [ ] Add comprehensive tests
- [ ] Add deployment configuration

## Known Limitations

- Bootstrap SCSS has deprecation warnings from Bootstrap's own code (not ours)
- No file upload system yet (planned)
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
7. Use Form Requests for validation
8. Keep controllers thin
