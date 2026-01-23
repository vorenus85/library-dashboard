#!/usr/bin/env bash
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Optimizing application..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache

echo "Starting PHP-FPM..."
exec php-fpm
