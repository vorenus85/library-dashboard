#!/usr/bin/env bash
set -e

echo "Running package discovery..."
# php artisan package:discover --ansi

echo "Running migrations..."
php artisan migrate --force

# Storage link
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

echo "Preparing uploads directory..."
mkdir -p storage/app/public/uploads

# Copy default images (only if not present)
if [ -d /var/www/docker/default-images ]; then
    cp -n /var/www/docker/default-images/* storage/app/public/uploads/
fi

echo "Optimizing application..."
php artisan optimize

echo "Starting Nginx + PHP-FPM..."
service nginx start
php-fpm
