# ============================================================
# Stage 1: Node.js — Build Vite/Tailwind frontend assets
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy package files first for layer caching
COPY package.json package-lock.json ./

# Install all node dependencies (including devDependencies for build)
RUN npm ci --prefer-offline

# Copy source files needed for build
COPY vite.config.js ./
COPY resources ./resources

# Build production assets
RUN npm run build

# ============================================================
# Stage 2: PHP 8.3 FPM — Production Laravel runtime
# ============================================================
FROM php:8.4-fpm-alpine AS production

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    oniguruma-dev \
    imagemagick \
    imagemagick-dev \
    icu-dev \
    mysql-client \
    postgresql-dev
    
# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        gd \
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        opcache \
        intl

# Install imagick via PECL (for PNG QR code export)
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del .build-deps

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for dependency caching
COPY composer.json composer.lock ./

# Install PHP dependencies — no dev packages, optimised autoloader
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-scripts \
        --optimize-autoloader \
        --prefer-dist

# Copy the full application
COPY . .

# Copy pre-built frontend assets from Node stage
COPY --from=frontend /app/public/build ./public/build

# Run post-install scripts now (package:discover)
RUN composer run-script post-autoload-dump || true

# Set correct ownership and permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Copy custom PHP production ini
COPY .docker/php/production.ini /usr/local/etc/php/conf.d/99-production.ini

# Copy and set entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]