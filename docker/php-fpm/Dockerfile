FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    zlib1g-dev \
    libxml2-dev \
    libpng-dev \
    libzip-dev \
    vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget nodejs zip unzip \
    gnupg gnupg1 gnupg2 \
    sudo \
    ssh

RUN docker-php-ext-install \
    pdo_mysql \
    soap \
    zip \
    opcache \
    gd \
    intl

COPY conf/opcache.ini /usr/local/etc/php/conf.d/
COPY conf/custom.ini /usr/local/etc/php/conf.d/
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer self-update

RUN usermod -u 1000 www-data
RUN usermod -a -G www-data root
RUN mkdir -p /var/www
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer
WORKDIR /var/www/html/
