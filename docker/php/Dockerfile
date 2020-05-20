FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y libpq-dev libicu-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_pgsql intl

WORKDIR /app