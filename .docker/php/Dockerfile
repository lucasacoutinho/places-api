FROM php:8.1-fpm-alpine

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
    unzip \
    git

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-enable gd && \
    docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:root . /var/www

EXPOSE 9000

CMD ["php-fpm"]
