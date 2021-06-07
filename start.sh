#!/bin/sh
php db-test.php
php artisan migrate
php artisan key:generate
php-fpm