FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN apk update && apk add --no-cache supervisor

RUN mkdir /var/www/bootstrap && mkdir /var/www/bootstrap/cache

WORKDIR /var/www

COPY bootstrap/app.php bootstrap/app.php
COPY app app
COPY config config
COPY public html
COPY resources resources
COPY routes routes
COPY database databanse
COPY storage storage
COPY artisan artisan
COPY composer.phar composer.phar
COPY composer.json composer.json
COPY composer.lock composer.lock
COPY challenge.json challenge.json

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

RUN php composer.phar install

COPY .env .env

RUN php artisan config:clear && php artisan migrate

EXPOSE 9000

CMD ["php-fpm"]