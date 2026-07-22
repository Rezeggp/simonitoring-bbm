FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpng-dev libzip-dev zip unzip
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork rewrite

# Arahkan ke folder public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html

# PENTING: Berikan akses tulis pada folder database dan file sqlite
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN touch /var/www/html/database/database.sqlite && chmod 664 /var/www/html/database/database.sqlite

CMD ["apache2-foreground"]