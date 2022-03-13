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


###############
#Install Chrome
###############
RUN curl -LO https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
RUN apt-get install -y ./google-chrome-stable_current_amd64.deb
RUN rm google-chrome-stable_current_amd64.deb

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage --disable-gpu --disable-extensions --remote-debugging-port=9222'
###############

#################################
# Install Java
#################################
USER root
RUN echo "deb http://security.debian.org/debian-security stretch/updates main" >> /etc/apt/sources.list
RUN mkdir -p /usr/share/man/man1 && \
    apt-get update -y && \
    apt-get install -y openjdk-8-jdk

RUN apt-get install unzip -y && \
    apt-get autoremove -y
#################################

RUN apt-get -y install xvfb

# INSTALL CHROMEDRIVER
RUN wget -N http://chromedriver.storage.googleapis.com/`curl -sS chromedriver.storage.googleapis.com/LATEST_RELEASE`/chromedriver_linux64.zip -P ~/ && \
    unzip ~/chromedriver_linux64.zip -d ~/ && \
    rm ~/chromedriver_linux64.zip && \
    mv -f ~/chromedriver /usr/local/bin/chromedriver && \
    chown root:root /usr/local/bin/chromedriver && \
    chmod 0755 /usr/local/bin/chromedriver


COPY conf/opcache.ini /usr/local/etc/php/conf.d/
COPY conf/custom.ini /usr/local/etc/php/conf.d/

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer self-update

COPY ./init.sh /tmp
RUN chmod +x /tmp/init.sh

# Add user www-data and set working directory
RUN usermod -u 1000 www-data
RUN usermod -a -G www-data root
RUN mkdir -p /var/www
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer

RUN adduser www-data sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

WORKDIR /var/www/html/
USER www-data

EXPOSE 9000

ENTRYPOINT ["sh", "/tmp/init.sh"]
