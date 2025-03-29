FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Laravel direto em /var/www
WORKDIR /var/www

COPY ./src /var/www

RUN composer install || echo "composer.json não encontrado, pulando install"
RUN [ -d storage ] && chown -R www-data:www-data storage bootstrap/cache || echo "Pasta storage não encontrada"
RUN [ -d storage ] && chmod -R 775 storage bootstrap/cache || echo "chmod storage pulado"

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
