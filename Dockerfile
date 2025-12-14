FROM php:8.2-apache

# Install dependency
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip unzip git \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

# Enable apache rewrite
RUN a2enmod rewrite

# FIX MPM ERROR (INI KUNCI)
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork

# Set document root ke public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Copy project
COPY . /var/www/html

# Permission writable
RUN chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
