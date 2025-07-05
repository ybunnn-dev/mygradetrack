#!/bin/sh
set -e

# Start PHP-FPM and Nginx
php-fpm -D
exec nginx -g "daemon off;"
