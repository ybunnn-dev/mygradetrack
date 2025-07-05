#!/bin/sh

# Replace __PORT__ in nginx config with the value of $PORT from Railway
sed -i "s/__PORT__/${PORT}/g" /etc/nginx/nginx.conf

# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground
nginx -g "daemon off;"
