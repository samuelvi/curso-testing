##################################################################################################################
FROM php:8.1.4-fpm

# Install Composer
RUN cd /tmp && curl -sS https://getcomposer.org/installer > composer.phar && \
    chmod +x /tmp/composer.phar && \
    mv /tmp/composer.phar /usr/local/bin/composer

RUN /usr/local/bin/php /usr/local/bin/composer && \
    mv composer.phar /usr/local/bin/composer


# Install Symfony Command
RUN cd /tmp && curl -sS https://get.symfony.com/cli/installer > symfony.phar && \
    chmod +x symfony.phar && \
    mv symfony.phar /usr/local/bin/symfony


# Install PHPUnit Globally
RUN cd /tmp && curl https://phar.phpunit.de/phpunit.phar > phpunit.phar && \
    chmod +x phpunit.phar && \
    mv /tmp/phpunit.phar /usr/local/bin/phpunit


RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget nodejs zip unzip \
    gnupg gnupg1 gnupg2 \
    zlib1g-dev \
    sudo \
    vim \
    libzip-dev


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
# Install Firefox and GeckoDriver
#################################
#ENV GECKODRIVER_VER v0.30.0
#ENV FIREFOX_VER 95.0
#
## Add latest FireFox
#RUN set -x \
#   && apt install -y \
#       libx11-xcb1 \
#       libdbus-glib-1-2 \
#   && curl -sSLO https://download-installer.cdn.mozilla.net/pub/firefox/releases/${FIREFOX_VER}/linux-x86_64/en-US/firefox-${FIREFOX_VER}.tar.bz2 \
#   && tar -jxf firefox-* \
#   && mv firefox /opt/ \
#   && chmod 755 /opt/firefox \
#   && chmod 755 /opt/firefox/firefox
#
## Add geckodriver
#RUN set -x \
#   && curl -sSLO https://github.com/mozilla/geckodriver/releases/download/${GECKODRIVER_VER}/geckodriver-${GECKODRIVER_VER}-linux64.tar.gz \
#   && tar zxf geckodriver-*.tar.gz \
#   && mv geckodriver /usr/bin/
#################################


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

#################################
# INSTALL CHROMEDRIVER
#################################
RUN wget -N http://chromedriver.storage.googleapis.com/`curl -sS chromedriver.storage.googleapis.com/LATEST_RELEASE`/chromedriver_linux64.zip -P ~/ && \
    unzip ~/chromedriver_linux64.zip -d ~/ && \
    rm ~/chromedriver_linux64.zip && \
    mv -f ~/chromedriver /usr/local/bin/chromedriver && \
    chown root:root /usr/local/bin/chromedriver && \
    chmod 0755 /usr/local/bin/chromedriver
#################################

RUN apt-get -y install xvfb


# install "ps" command
RUN apt-get update && apt-get install -y procps

# INSTALL REDIS
RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_mysql opcache zip

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# INSTALL XDEBUG
RUN pecl install xdebug
# DO NOT ENABLE xdebug
# RUN docker-php-ext-enable xdebug

COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/php-fpm-pool.conf /usr/local/etc/php/pool.d/www.conf
COPY conf/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# ENABLE XDEBUG BY UNCOMMENTING THE FOLLOWING LINE:
# COPY conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN adduser www-data sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN mkdir -p /var/www/.cache
RUN chown www-data:www-data /var/www/.cache

WORKDIR /var/www/html
USER www-data
RUN chown www-data:www-data /var/www/html

RUN mkdir -p /var/www/html/var/log
RUN chown www-data:www-data /var/www/html/var/log

# Install composer from oficial image
COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 9000

# ENTRYPOINT ["sh", "./docker/php/init.sh"]
# CMD ["./docker/php/init.sh"]
##################################################################################################################
