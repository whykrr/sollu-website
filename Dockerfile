# Stage 1: Build dependencies
FROM php:8.3-fpm-alpine as build

RUN apk add --no-cache \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    postgresql-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        pdo_pgsql \
        zip \
        gd \
        intl \
        opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Install dependencies tanpa dev-tools untuk performa maksimal
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: Final Production Image
FROM php:8.3-fpm-alpine

# Install runtime dependencies saja
RUN apk add --no-cache \
    nginx supervisor libzip libpng libjpeg-turbo freetype icu libpq

WORKDIR /var/www/html

# Copy aplikasi dari stage build
COPY --from=build --chown=www-data:www-data /var/www/html /var/www/html
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copy konfigurasi custom (Harus Anda buat di folder ./docker/...)
COPY ./docker/nginx.conf /etc/nginx/http.d/default.conf
COPY ./docker/supervisord.conf /etc/supervisord.conf
COPY ./docker/php-production.ini /usr/local/etc/php/conf.d/app.ini

# Permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
