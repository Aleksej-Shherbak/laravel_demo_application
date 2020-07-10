FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip \
    && apt-get install libpq-dev -y \
    && pecl install xdebug-2.9.6 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_pgsql pgsql

ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www
