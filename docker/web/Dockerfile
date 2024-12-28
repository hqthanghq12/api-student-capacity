# Set master image
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install Additional dependencies
RUN apk update && apk add --no-cache \
    build-base shadow supervisor \
    freetype-dev \
    libpng-dev \
    jpeg-dev \
    libjpeg-turbo-dev \
    libbz2 \
    libzip-dev \
    zip \
    unzip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install nodejs
RUN apk add --update nodejs npm

# Add and Enable PHP-PDO Extenstions for PHP connect Mysql
RUN docker-php-ext-configure gd
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mysqli gd zip
RUN #docker-php-ext-install -j$(nproc) unzip
RUN docker-php-ext-enable pdo_mysql mysqli

# Remove Cache
RUN rm -rf /var/cache/apk/*

COPY ./docker/supervisord.conf /etc/supervisord.conf
COPY ./docker/supervisor.d /etc/supervisor.d

# Use the default production configuration for PHP-FPM ($PHP_INI_DIR variable already set by the default image)
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory
COPY ../.. .

# Chang app directory permission
RUN chown -R www-data:www-data .

ENV ENABLE_CRONTAB 1
ENV ENABLE_WORKER 1

ENTRYPOINT ["sh", "/var/www/html/docker/docker-entrypoint.sh"]

CMD supervisord -n -c /etc/supervisord.conf
