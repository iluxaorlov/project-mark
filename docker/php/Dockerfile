FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_pgsql

WORKDIR /app