FROM php:8.5-cli-alpine

RUN apk add --no-cache libpq-dev libzip-dev unzip curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath opcache \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
