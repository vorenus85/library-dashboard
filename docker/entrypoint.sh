#!/bin/bash
# Entry point script for Laravel Docker container

# Ensure Laravel storage and cache folders exist
mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions storage/app/public/images

# Set permissions for PHP (www-data)
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Create the public/storage symlink (if it doesn't exist)
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

# Copy default images (only if not already present)
if [ -d /var/www/docker/default-images ]; then
    cp -n /var/www/docker/default-images/* storage/app/public/images/
fi

# Run the main container command
exec "$@"
