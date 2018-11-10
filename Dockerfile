FROM php:7.2-apache

RUN apt-get update


RUN apt-get install git zip zlib1g-dev -y \
  && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

RUN a2enmod rewrite
# RUN composer install --prefer-source --no-interaction

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"