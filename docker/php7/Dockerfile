FROM php:7.3-apache
RUN rm /etc/apt/preferences.d/no-debian-php

RUN docker-php-ext-install calendar && docker-php-ext-configure calendar

RUN apt-get update -y \
  && apt-get install -y

RUN apt install zip unzip

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --prefer-dist

RUN apt install wget; 

# Install PHPUnit
RUN wget https://phar.phpunit.de/phpunit.phar -O /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

WORKDIR /usr/src/lendinvest-test