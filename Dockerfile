FROM php:8.3-alpine

# Install sistem dasar yang dibutuhkan Laravel
RUN apk add --no-cache libpng-dev libzip-dev zip unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql gd zip

# Copy semua file ke dalam server
WORKDIR /var/www/html
COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Jalankan server bawaan Laravel (Tanpa Apache!)
CMD php artisan serve --host=0.0.0.0 --port=$PORT