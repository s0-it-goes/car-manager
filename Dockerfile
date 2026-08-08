FROM php:8.5-fpm

ARG UID=1000
ARG GID=1000

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    curl \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupmod -o -g ${GID} www-data \
    && usermod -o -u ${UID} -g ${GID} www-data

RUN mkdir -p /tmp/.config \
    && chown -R www-data:www-data /tmp/.config

ENV HOME=/var/www
ENV XDG_CONFIG_HOME=/tmp/.config

USER www-data