FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
        git curl libzip-dev zip \
        && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install zip pdo pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN set -eux; \
    deluser www-data || true; \
    groupadd -g ${GID} www-data; \
    useradd -u ${UID} -g www-data www-data; \
    chown -R www-data:www-data /var/www

USER www-data
