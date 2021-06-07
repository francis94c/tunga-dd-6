#!/bin/sh
php db-test.php
php artisan key:generate

role=${CONTAINER_ROLE}

if [ "$role" = "app" ]; then
    php artisan migrate
    php-fpm
elif [ "$role" = "queue" ]; then
    echo "Running the queue..."
    php artisan queue:work --verbose --tries=3 --timeout=90
fi
