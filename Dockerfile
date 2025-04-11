FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libzip-dev \
    libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

COPY . .

RUN composer install

CMD ["php-fpm"]
