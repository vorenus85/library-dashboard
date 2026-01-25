#!/usr/bin/env bash
set -e

echo "Running package discovery..."
php artisan package:discover --ansi

echo "Running migrations..."
php artisan migrate --force

# Storage link
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

echo "Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache

echo "Starting Nginx + PHP-FPM..."
service nginx start
php-fpm
