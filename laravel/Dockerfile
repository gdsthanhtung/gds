FROM php:8.1-fpm-alpine
RUN apk update && apk add oniguruma-dev && apk add libzip-dev
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer