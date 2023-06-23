FROM php:8.1-fpm-alpine

# ENV APP_ENV production
# ENV APP_DEBUG false

RUN apk update && \
    apk add --no-cache $PHPIZE_DEPS\
    curl \
    oniguruma-dev \
    libpq-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    jpegoptim optipng pngquant gifsicle \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-enable gd && \
    docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis


WORKDIR /var/www

COPY . .

COPY .env.example .env

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache
    
# Install dependencies
RUN su www-data -s /bin/sh -c "composer install --optimize-autoloader --no-dev"


EXPOSE 9000

CMD ["php-fpm"]
