FROM php:8.1.3-fpm-alpine

# Install system dependencies
RUN apk --update add --no-cache \
    libpng-dev \
    postgresql-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

# Install symfony CLI
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | sh \
    && apk add symfony-cli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Allow for superuser install
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Symfony dependencies
RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
