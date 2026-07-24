#!/bin/sh
set -e

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  Laravel Starter Kit - Docker Startup"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Wait for PostgreSQL
echo "→ Waiting for PostgreSQL..."
until pg_isready -h postgres -p 5432 -U postgres > /dev/null 2>&1; do
    sleep 1
done
echo "✓ PostgreSQL is ready"

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "→ Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "→ Running migrations..."
php artisan migrate --force 2>/dev/null || echo "⚠ Migrations skipped (already up or DB issue)"

# Seed database (first run only)
if [ ! -f /var/www/html/.seeded ]; then
    echo "→ Seeding database..."
    php artisan db:seed --force 2>/dev/null && touch /var/www/html/.seeded || echo "⚠ Seeding skipped"
fi

# Create storage symlink
echo "→ Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Clear and rebuild caches
echo "→ Building caches..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

# Set permissions
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "  ✓ Application ready!"
echo "  → http://localhost:${APP_PORT:-8000}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"

# Start supervisord (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
