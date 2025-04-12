FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    curl \
    wget \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    build-essential \
    autoconf \
    libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql zip curl mbstring

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

COPY . .

RUN composer install

ENV PORT=8080

EXPOSE 8080

CMD ["php-fpm"]

CMD ["php", "artisan", "serve"]
