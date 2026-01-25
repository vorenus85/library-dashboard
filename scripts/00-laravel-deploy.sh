#!/usr/bin/env bash
set -e

echo "Running package discovery..."
# php artisan package:discover --ansi

echo "Running migrations..."
php artisan migrate --force

echo "Optimizing application..."
php artisan optimize

echo "Starting Nginx + PHP-FPM..."
service nginx start
php-fpm
