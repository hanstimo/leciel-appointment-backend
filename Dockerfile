FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan migrate --force && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=$PORT
