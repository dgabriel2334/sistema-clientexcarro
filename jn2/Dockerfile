FROM php:7.2-apache

RUN a2enmod rewrite

COPY ./ /var/www/html/

RUN service apache2 restart

RUN apt-get update -y && apt-get install -y libmariadb-dev

RUN docker-php-ext-install mysqli