FROM php:8.4.1-fpm

### Setup environment
RUN apt-get update -y && apt-get install -y zip unzip ngrep
RUN pecl install xdebug mongodb && docker-php-ext-enable xdebug mongodb

### Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

WORKDIR /app
COPY ../.. ./
