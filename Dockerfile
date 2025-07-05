# Stage 1: Build frontend assets
FROM node:20-alpine as nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build --force

# Stage 2: Laravel app with PHP-FPM and Nginx
# IMPORTANT: Use fpm-alpine, not cli
FROM php:8.2-fpm-alpine as laravelapp

# Install system dependencies (including Nginx) and PHP extension development packages
RUN apk update && apk add --no-cache \
    build-base \
    git \
    curl \
    zip \
    unzip \
    nginx \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxml2-dev \
    oniguruma-dev \
    && rm -rf /var/cache/apk/*

# Install PHP extensions
# Use -j$(nproc) for parallel compilation to speed up build
RUN docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    zip \
    gd \
    mbstring \
    bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set Laravel working directory
WORKDIR /var/www

# Copy application source (ensure .dockerignore is set up to exclude node_modules, .git, etc.)
COPY . .

# Copy built frontend from nodebuild stage
# This copies the 'build' directory containing compiled assets from Vite
COPY --from=nodebuild /app/public/build /var/www/public/build

# Configure Nginx for Laravel
# Copy your custom Nginx configuration file
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Set correct permissions for Laravel directories
# www-data is the user PHP-FPM runs as in these images
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && find /var/www -type d -exec chmod 755 {} \; \
    && find /var/www -type f -exec chmod 644 {} \;

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel production optimizations (clear caches and re-cache for production)
RUN php artisan config:clear && php artisan view:clear
RUN php artisan config:cache
# RUN php artisan route:cache # Uncomment if your routes are not dynamic
# RUN php artisan view:cache  # Uncomment if you want view cache

# Expose Nginx's default HTTP port
EXPOSE 80

# Custom entrypoint to run PHP-FPM and Nginx simultaneously
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["nginx"]
