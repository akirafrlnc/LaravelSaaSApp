FROM php:8.2-fpm

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    git \
    iputils-ping \
    libpq-dev \
    unzip \
    redis-server && \
    docker-php-ext-install pdo pdo_pgsql && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install

# Generate application key and cache configuration
RUN php artisan key:generate
RUN php artisan config:clear && php artisan config:cache

CMD ["php-fpm"]
