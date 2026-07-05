FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    ctype \
    fileinfo \
    bcmath \
    gd \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000