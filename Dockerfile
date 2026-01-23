FROM php:8.3-fpm

# System deps
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps first (cache-friendly)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# Copy app
COPY . .

# Permissions
RUN chown -R www-data:www-data \
    storage bootstrap/cache

# Entrypoint
COPY scripts/00-laravel-deploy.sh /start.sh
RUN chmod +x /start.sh

ENV APP_ENV=production
ENV APP_DEBUG=false

ENTRYPOINT ["/start.sh"]
