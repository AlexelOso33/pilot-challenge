FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    openssl \
    libssl-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql zip xml

COPY . /var/www/html/
WORKDIR /var/www/html/
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN chown -R www-data:www-data storage bootstrap/cache
RUN touch database/database.sqlite

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000