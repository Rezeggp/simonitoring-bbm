FROM php:8.3-apache

# Install kebutuhan dasar
RUN apt-get update && apt-get install -y libpng-dev libzip-dev zip unzip

# KUNCI UTAMA: Matikan SEMUA modul MPM yang mungkin bentrok, lalu aktifkan satu saja (prefork)
RUN a2dismod mpm_event mpm_worker mpm_event && a2enmod mpm_prefork rewrite

# Arahkan ke folder public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copy data
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Port
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]