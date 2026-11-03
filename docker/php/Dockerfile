FROM php:8.5-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libonig-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js (LTS) and NPM
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install official PHP extension installer helper
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install required PHP extensions (PostgreSQL, Redis, and standard Laravel extensions)
RUN install-php-extensions \
    pdo_pgsql \
    pgsql \
    redis \
    bcmath \
    gd \
    intl \
    zip \
    pcntl \
    opcache \
    exif

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Match container user UID and GID to host user (default 1000)
ARG UID=1000
ARG GID=1000

RUN groupmod -o -g ${GID} www-data 2>/dev/null || true \
    && usermod -o -u ${UID} -g ${GID} www-data 2>/dev/null || true

# Prepare composer and npm cache directories and git config
RUN mkdir -p /var/www/.composer /var/www/.config /var/www/.npm \
    && chown -R www-data:www-data /var/www \
    && su - www-data -s /bin/sh -c "git config --global --add safe.directory /var/www/html"

ENV COMPOSER_HOME=/var/www/.composer
ENV npm_config_cache=/var/www/.npm

WORKDIR /var/www/html

USER www-data

EXPOSE 9000 5173

CMD ["php-fpm"]
