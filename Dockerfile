FROM php:8.3-apache

# 1. Install dependensi dasar yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y libpng-dev libzip-dev zip unzip

# 2. Aktifkan modul Apache yang benar dan matikan yang bentrok
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork rewrite

# 3. Arahkan DocumentRoot ke folder 'public' (khas Laravel)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 4. Set permission agar bisa dibaca server
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# 5. Jalankan Apache di foreground
CMD ["apache2-foreground"]