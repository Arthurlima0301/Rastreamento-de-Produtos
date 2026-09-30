FROM php:8.3-fpm

RUN apt-get update && \
    apt-get install -y libzip-dev nodejs npm && \
    docker-php-ext-install zip pdo_mysql
    

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer