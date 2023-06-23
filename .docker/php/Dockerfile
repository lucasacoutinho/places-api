FROM php:8.1-fpm

WORKDIR /var/www

# Setup basic dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    curl \
    libxml2-dev \
    libpng-dev \
    zip \
    unzip \
    libzip-dev

# Setup php extensions
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath

# Setup redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# Setup composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Setup permissions

RUN groupadd -g 1000 www

RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www

COPY --chown=www:www . /var/www

RUN chmod -R 755 /var/www/storage

USER www

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
