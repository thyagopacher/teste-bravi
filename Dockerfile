#PHP - Apache 
FROM php:7.3-apache

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

RUN docker-php-ext-install mysqli pdo_mysql
RUN a2enmod rewrite
RUN service apache2 restart

COPY ./ /var/www/html/

#
# Expose port 80
EXPOSE 80
