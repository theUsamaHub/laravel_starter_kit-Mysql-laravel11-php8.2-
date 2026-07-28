# Laravel Starter Kit — Features

## Authentication
- Registration, Login, Logout
- Password Reset (forgot/reset via email)
- Email Verification (signed URL, resend throttled 6:1)
- Password Confirmation for sensitive actions
- Password Update
- Login Rate Limiting (5 attempts per email+IP)
- API Token Auth via Sanctum (register/login/logout, token management)
- Session-based Web Auth + Token-based API Auth side by side

## User Profile
- Edit Profile (name, email — re-verifies on email change)
- Delete Account (requires current password)
- API Profile Update

## Admin Panel — Dashboard
- Stats widgets (Users, Categories, Contacts, Tags, Roles, Media counts)
- Bar chart (users/contacts last 7 days)
- Activity summary for today
- Recent users list
- Quick action buttons (Create Category, Upload Media, View Logs, Backup)

## Admin Panel — User Management
- List users with search (name/email)
- View user detail
- Edit user (name, email, password, role assignment)
- Delete user (self-deletion blocked)

## Admin Panel — Roles & Permissions
- List roles with user count
- Create/Edit roles with auto-discovered module permissions
- Delete roles (blocked if users assigned)
- Permissions grouped by module in UI
- Admin auto-bypass for all permissions

## Admin Panel — Categories
- Full CRUD with soft deletes
- Image upload (main image + multiple attachments)
- Polymorphic media attachment
- Tagging support
- Auto-slug generation
- Sort order, active toggle, description, body
- Audit trail (created/updated by, activity log)

## Admin Panel — Tags
- Full CRUD
- Color picker, auto-slug
- Polymorphic tagging with categories

## Admin Panel — Media Library
- Upload up to 10 files at once (jpg, png, gif, webp, pdf, doc, docx, xls, xlsx, csv, txt)
- Search by name/original_name
- Filter by MIME type (Images, PDF, Office, CSV)
- File size display, type icons, image thumbnails
- Delete files

## Admin Panel — Contact Submissions
- Inbox with search (name/email/message)
- Filter by status (new/read/replied)
- Auto-mark as read on view
- Delete submissions

## Admin Panel — Settings
- Grouped settings editor (General, SEO, Social)
- Type-aware (boolean, number, json, text)
- Create new settings, delete existing
- Database-backed with caching

## Admin Panel — Dynamic Validation Rules
- Per-form validation rules stored in database
- Custom error messages per field
- Auto-merges with hardcoded rules
- Full CRUD UI

## Admin Panel — Activity Logs
- Filterable by event (created/updated/deleted), user, search
- Truncate all logs

## Admin Panel — Log Viewer
- Tail last 200 lines of Laravel log
- Clear log file
- Download log as laravel-{timestamp}.log

## Admin Panel — Database Backup
- List backups with name, size, date
- Create PostgreSQL SQL dump (TRUNCATE + INSERT per table)
- Download backup files
- Delete backup files

## Public Frontend Pages
- Home (welcome)
- About
- Services
- Contact form (submission saves to DB, notifies all admin users via email + database notification)

## REST API (v1)
- Health check endpoint
- Auth: register, login, logout (token-based via Sanctum)
- Profile: get current user, update
- Categories: full CRUD (admin only)
- Users: list, show, update, delete (admin only)
- JSON Resources for consistent response format

## Media & File Handling
- Polymorphic `HasMedia` trait for any model
- Single and multiple file upload
- File type categorization (images, documents, spreadsheets)
- MIME type validation and max size enforcement
- Configurable storage disk
- URL generation for public access

## Tagging
- Polymorphic `HasTags` trait for any model
- Auto-create tags by name/slug
- Attach/detach/sync tags

## Activity Logging & Auditing
- `LogsActivity` trait auto-logs created/updated/deleted events
- Stores old/new values, IP address, user agent
- Activity summary on dashboard

## Notifications
- Queueable contact form notification (email to all admins)
- Queueable welcome notification (email + database)

## Dynamic Validation
- Database-driven validation rules per form name
- Hardcoded + dynamic rule merging
- Custom error messages from database
- Admin UI for managing rules

## Security
- Role-based middleware (`role:admin`)
- Permission-based middleware (`permission:module.action`)
- Admin auto-bypass for all permissions
- Email verification required for admin access
- Password confirmation for sensitive actions
- Login rate limiting
- CSRF protection

## Database
- 16 tables: users, roles, role_user, categories, media, tags, taggables, contacts, settings, activity_logs, validation_rules, sessions, cache, jobs, personal_access_tokens, failed_jobs
- Soft deletes on categories
- JSON columns for permissions, audit values
- Polymorphic relationships (media, tags, activity logs)

## Developer Experience
- Vite + Bootstrap 5 + Alpine.js frontend build
- Docker support (Dockerfile, docker-compose.yml)
- PHPUnit configured
- Seeders with demo data (admin/user accounts, categories, settings)
- Global helper functions (slug, date formatting, initials, truncation)
- Composer dev scripts (dev server + queue + logs + Vite concurrently)
- Pint (PHP CS Fixer) configured
