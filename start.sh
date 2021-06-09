#!/bin/sh
php db-test.php
php artisan key:generate

role=${CONTAINER_ROLE}

if [ "$role" = "app" ]; then
    php artisan migrate
    chmod 777 /var/www/storage/logs/laravel.log
    chmod -R 777 /var/www/storage/framework/sessions
    php-fpm
elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    php artisan queue:work --verbose --tries=3 --timeout=90
fi
