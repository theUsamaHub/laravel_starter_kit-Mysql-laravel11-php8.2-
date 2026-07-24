# ── Laravel Starter Kit - Dockerfile ──
# Multi-stage build for production optimization

# Stage 1: Build assets with Node
FROM node:20-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts
COPY vite.config.js ./
COPY resources/ ./resources/
RUN npm run build

# Stage 2: PHP dependencies
FROM php:8.3-fpm-alpine AS composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN apk add --no-cache unzip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip bcmath opcache \
    && composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Stage 3: Final image
FROM php:8.3-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    libpq-dev \
    icu-dev \
    oniguruma-dev \
    supervisor \
    nginx \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        bcmath \
        mbstring \
        xml \
        opcache \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis

# PHP configuration
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Nginx configuration
COPY docker/nginx/app.conf /etc/nginx/http.d/default.conf

# Application setup
WORKDIR /var/www/html
COPY --from=composer /app/vendor vendor
COPY . .
COPY --from=node-build /app/public/build public/build

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chmod -R 775 public/storage 2>/dev/null || true

# Supervisor config
COPY docker/scripts/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

COPY docker/scripts/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
