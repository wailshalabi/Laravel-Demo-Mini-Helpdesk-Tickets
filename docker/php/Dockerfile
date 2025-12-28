FROM php:8.3-fpm-alpine

# Runtime deps
RUN apk add --no-cache \
  bash curl git unzip icu-dev oniguruma-dev libzip-dev mysql-client

# Build deps needed for pecl/phpize (autoconf, gcc, make, etc.)
RUN apk add --no-cache --virtual .build-deps \
  $PHPIZE_DEPS autoconf g++ make linux-headers

# PHP extensions
RUN docker-php-ext-install intl pdo pdo_mysql mbstring zip opcache

# Redis extension
RUN pecl install redis \
  && docker-php-ext-enable redis \
  && apk del .build-deps

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/storage/framework/sessions \
    /var/www/html/bootstrap/cache \
 && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY php.ini /usr/local/etc/php/conf.d/99-custom.ini

CMD ["php-fpm"]
