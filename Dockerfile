# Menggunakan image PHP resmi
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y libpng-dev libzip-dev zip unzip
RUN docker-php-ext-install pdo_mysql gd zip

# Set folder kerja
WORKDIR /var/www/html

# Copy project ke dalam container
COPY . .

# Set permission agar Laravel bisa menulis ke folder storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ubah konfigurasi Apache ke folder public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite untuk route Laravel
RUN a2enmod rewrite