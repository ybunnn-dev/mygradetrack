# Stage 1: Build assets with Node
FROM node:20-alpine as nodebuild
WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Stage 2: Laravel app with PHP
FROM php:8.2-cli

# Install PHP extensions
RUN apk add --no-cache \
    zip unzip curl git libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy application files
COPY . .

# Copy built Vite assets
COPY --from=nodebuild /app/public /var/www/public

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache clear to avoid stale views/config
RUN php artisan config:clear && php artisan view:clear

# Permissions
RUN chmod -R 755 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Run Laravel using PHP built-in server (serves static assets too)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
