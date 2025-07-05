#!/bin/sh

# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground.
# Nginx needs to stay in the foreground for the Docker container to keep running.
exec nginx -g "daemon off;"