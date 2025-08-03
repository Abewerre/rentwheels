FROM php:8.2-apache

# Ganti Apache agar dengar di port 8080 (Railway default)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Aktifkan mod_rewrite (jika perlu untuk routing)
RUN a2enmod rewrite

# Salin semua file project ke folder web server
COPY . /var/www/html/

# Pastikan permission benar
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080