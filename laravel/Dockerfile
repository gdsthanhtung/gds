FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    libzip-dev \
    oniguruma-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    freetype-dev

RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
