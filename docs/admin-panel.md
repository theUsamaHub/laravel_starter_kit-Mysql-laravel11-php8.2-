# Admin Panel Guide

## Access

URL: `/admin` (requires login + email verification + admin role)

## Dashboard

The dashboard shows:
- **6 stats cards** — Users, Categories, Contacts (with "new" badge), Tags, Roles, Media
- **7-day chart** — Users & Contacts created per day
- **Today's activity** — Created/Updated/Deleted event breakdown
- **Recent users** — Last 5 registered users
- **Quick actions** — One-click links to common tasks

## Modules

### Categories
Manage content categories with:
- Full CRUD with soft deletes (Recycle Bin available)
- Image upload + multiple file attachments
- Tagging support with color-coded tags
- Sort order for custom ordering
- Scheduled publishing (set future publish/unpublish dates)
- WYSIWYG editor (Quill) for description
- Auto-slug generation

### Users
- View all registered users with search
- Edit user details and assign roles
- Delete users (self-deletion blocked)
- Stats: total, admin count, verified count

### Roles & Permissions
- Create/edit/delete roles
- Permissions auto-discovered from admin controllers
- Grouped by module in a clean checkbox UI
- Admin role bypasses all permission checks

### Contacts
- Inbox for contact form submissions
- Search by name/email/message
- Filter by status (new/read/replied)
- Auto-marks as "read" when viewed
- Stats: total, new, read, replied

### Tags
- Color-coded tagging system
- Polymorphic (usable by any model)
- Auto-slug from name
- Stats: total tags, categories tagged

### Media Library
- File upload with drag-and-drop (up to 10 files)
- Search by name/original name
- Filter by type (Images, PDF, Documents, Spreadsheets)
- Thumbnails for images
- File size display

### Settings
Grouped settings editor:
- **General** — App name, description, email
- **SEO** — Meta title, description, keywords
- **Social** — Facebook, Twitter, Instagram, LinkedIn URLs
- **Mail** — SMTP configuration (driver, host, port, credentials, from address, additional emails)

### Validation Rules
Manage dynamic validation rules per form:
- `contact_form` — Override contact form validation
- `user_register` — Override registration validation
- Add new forms with custom rules and error messages

### Activity Logs
Audit trail for all model changes:
- Filter by event (created/updated/deleted), user, date range
- Search by auditable type or user name
- Export filtered results to CSV
- Clear all logs

### Notifications
In-app notification inbox:
- View all notifications with type icons
- Filter All/Unread
- Mark individual or all as read
- Delete notifications

### Subscribers
Newsletter subscriber management:
- Search by email or name
- Filter Active/Unsubscribed
- Export to CSV (respects current filters)
- Stats: total, active, unsubscribed

### IP Restrictions
Whitelist IP addresses for admin access:
- Supports exact IPs, wildcards (203.0.113.*), and CIDR (10.0.0.0/8)
- Empty list = all IPs allowed
- Shows your current IP

### Sessions
View and manage active user sessions:
- See user, IP, user agent, last activity
- Revoke sessions (cannot revoke your own)

### Maintenance Mode
DB-backed maintenance mode:
- Toggle on/off
- Custom maintenance message
- Configure bypass routes (routes that stay accessible)
- Shows 503 page with message

### Health Dashboard
System health checks:
- Database connection, cache accessibility
- Queue worker status
- Storage disk usage
- PHP/Laravel version, environment

### Log Viewer
- Tail last 200 lines of `storage/logs/laravel.log`
- Clear logs
- Download log file

### Database Backup
- Create PostgreSQL SQL dumps (TRUNCATE + INSERT)
- See backup name, size, date
- Download or delete backups

## Command Palette

Press **Ctrl+K** from any admin page to open a searchable navigation modal. Type to filter, arrow keys to navigate, Enter to go.
