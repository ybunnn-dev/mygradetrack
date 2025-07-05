# Complete nginx.conf file (use this if the conf.d approach doesn't work)
user www-data;
worker_processes auto;
pid /run/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;

    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                    '$status $body_bytes_sent "$http_referer" '
                    '"$http_user_agent" "$http_x_forwarded_for"';

    access_log /var/log/nginx/access.log main;
    error_log /var/log/nginx/error.log;

    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;

    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

    server {
        listen 80;
        server_name _;
        root /var/www/public;

        # Basic Nginx headers for security
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Content-Type-Options "nosniff";

        index index.php index.html index.htm;

        charset utf-8;

        # Try serving static files directly, then fall back to index.php for Laravel routing
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        # Handle PHP files by passing requests to PHP-FPM
        location ~ \.php$ {
            # This points to the PHP-FPM process (it runs on port 9000 by default)
            # Since PHP-FPM is running in the same container, use 127.0.0.1 (localhost)
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_buffers 16 16k;
            fastcgi_buffer_size 32k;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }

        # Deny access to hidden files (except for .well-known for SSL validation)
        location ~ /\.(?!well-known).* {
            deny all;
        }

        # Handle 404 errors by passing them to Laravel's index.php
        error_page 404 /index.php;
    }
}
