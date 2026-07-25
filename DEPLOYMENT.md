# Laravel Starter Kit - Deployment Guide

## Environment Variables for Production

Copy these variables into your hosting platform (Railway, Render, etc.)

```
# ── App ──────────────────────────────────────────────────────────
APP_NAME=LaravelStarterKit
APP_ENV=production
APP_KEY=base64:GENERATE_NEW_KEY_WITH_php_artisan_key_generate
APP_DEBUG=false
APP_URL=https://your-app-domain.com

# ── Locale ───────────────────────────────────────────────────────
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

# ── Maintenance ──────────────────────────────────────────────────
APP_MAINTENANCE_DRIVER=database

# ── Security ─────────────────────────────────────────────────────
BCRYPT_ROUNDS=12

# ── Logging ──────────────────────────────────────────────────────
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=warning

# ── Database (NeonDB PostgreSQL) ──────────────────────────────────
DB_CONNECTION=pgsql
DB_HOST=ep-ancient-tree-azlzwguq.c-3.ap-southeast-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=npg_nyCk58vOtLPJ

# ── Session ──────────────────────────────────────────────────────
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_PATH=/
SESSION_DOMAIN=.your-app-domain.com

# ── Cache & Queue ────────────────────────────────────────────────
CACHE_STORE=database
QUEUE_CONNECTION=database
BROADCAST_CONNECTION=log

# ── Filesystem ───────────────────────────────────────────────────
FILESYSTEM_DISK=local

# ── Mail (SMTP) ──────────────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=you@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=you@gmail.com
MAIL_FROM_NAME=LaravelStarterKit

# ── Vite (build-time) ────────────────────────────────────────────
VITE_APP_NAME=LaravelStarterKit
```

## How to Generate APP_KEY

Run locally and copy the output:
```bash
php artisan key:generate
```
It will output something like:
```
Application key [base64:xyz123...] set successfully.
```
Copy that full `base64:...` value into your `APP_KEY` variable.

## Railway Deployment

### Step 1: Connect Repository
1. Go to railway.app
2. Click "New Project" → "Deploy from GitHub Repo"
3. Select your repository

### Step 2: Add Variables
1. Go to your project → "Variables" tab
2. Click "Raw Editor" and paste all variables above
3. Update `APP_URL` to your Railway domain

### Step 3: Add Build Command
Create `railway.toml` in project root:
```toml
[build]
builder = "nixpacks"
buildCommand = "composer install --no-dev && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache"

[deploy]
startCommand = "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"
healthcheckPath = "/up"
healthcheckTimeout = 300
```

### Step 4: Deploy
Push to GitHub. Railway auto-deploys.

## Render Deployment

### Step 1: Connect Repository
1. Go to render.com
2. Click "New" → "Web Service"
3. Connect your GitHub repo

### Step 2: Configure
- **Environment:** PHP
- **Build Command:**
  ```
  composer install --no-dev
  npm install
  npm run build
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```
- **Start Command:**
  ```
  php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
  ```

### Step 3: Add Environment Variables
Go to "Environment" tab → paste all variables from above.

### Step 4: Deploy
Click "Create Web Service". Render auto-deploys.

## Vercel Deployment

Create `vercel.json`:
```json
{
  "version": 2,
  "builds": [
    { "src": "artisan", "use": "vercel-php" },
    { "src": "public/**", "use": "@vercel/static" }
  ],
  "routes": [
    { "src": "/(.*)", "dest": "artisan" }
  ]
}
```
Set environment variables in Vercel dashboard.

## Docker Production

```bash
# Build
docker compose -f docker-compose.prod.yml build

# Run
docker compose -f docker-compose.prod.yml up -d
```

## Post-Deployment Checklist

After first deploy, run these commands:
```bash
php artisan migrate --force      # Run migrations
php artisan db:seed --force      # Seed database
php artisan storage:link         # Create storage symlink
php artisan config:cache         # Cache config
php artisan route:cache          # Cache routes
php artisan view:cache           # Cache views
php artisan optimize             # Optimize everything
```

## What Works Without Extra Setup

| Feature | Status |
|---------|--------|
| Authentication (login/register) | Works |
| Admin panel | Works |
| Roles & permissions | Works |
| Category CRUD | Works |
| User management | Works |
| Contact form | Works |
| File uploads | Works (local disk) |
| Email notifications | Needs SMTP config |
| Maintenance mode | Works (database driver) |
| Activity logs | Works |
| Database backup | Works |
| API (Sanctum) | Works |
| Tags system | Works |

## Optional Upgrades for Production

### Redis (Better Performance)
```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379
```

### S3 File Storage
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
```

### Mail (SendGrid/Postmark)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

## Troubleshooting

### Migration fails on NeonDB
Use direct host (without `-pooler`):
```
DB_HOST=ep-ancient-tree-azlzwguq.c-3.ap-southeast-1.aws.neon.tech
```

### 500 Error in Production
1. Check `storage/logs/laravel.log`
2. Make sure `APP_DEBUG=false`
3. Make sure `APP_KEY` is set

### Storage/Uploads Not Working
Run: `php artisan storage:link`

### Email Not Sending
Check SMTP credentials. For Gmail, use App Password (not regular password).

### Session Not Persisting
Make sure `SESSION_DRIVER=database` and `sessions` table exists.
