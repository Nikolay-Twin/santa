FROM php:8.2-fpm

ARG APP_ENV='dev'

# settings
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install needed packages
RUN apt-get update; \
    apt-get -y upgrade; \
    apt-get install -y; \
    apt-get install -y --no-install-recommends apt-utils apt-transport-https; \
    apt-get install -y --no-install-recommends \
        nano libxslt1-dev libonig-dev libpq-dev wget gnupg git sudo \
        lsb-release ca-certificates openssh-server iproute2 \
        libzip-dev zlib1g-dev libpcre3-dev unzip libicu-dev \
        libhiredis-dev libjpeg-dev libpng-dev sshpass \
        libwebp-dev libxpm-dev libfreetype6-dev;

# config
COPY ./www.conf /usr/local/etc/php-fpm.d/www.conf
RUN mkdir /var/www/html; \
    chmod 777 /var/www/html

# php extensions
RUN docker-php-ext-install xsl pdo_mysql iconv zip mbstring intl sockets

# install composer, speed up composer; symlink php; change www-data passwd
RUN apt-get update && apt-get install -y curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN touch /var/run/8.2-fpm.pid; \
    chown www-data /var/run/8.2-fpm.pid;

RUN chown www-data:www-data -R /var/www;

# args for fixperms...
ARG LOCAL_UID
ENV LOCAL_UID $LOCAL_UID

ARG LOCAL_GID
ENV LOCAL_GID $LOCAL_GID

ARG APP_USER
ENV APP_USER $APP_USER

ARG APP_GROUP
ENV APP_GROUP $APP_GROUP

RUN mkdir -p /var/log/symfony
RUN chmod a+rwx -R /var/log/symfony

# add www-data to sudoers with no-password
RUN echo "www-data ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

RUN rm -rf /tmp/* /var/tmp/* /usr/share/doc/*

# Configure FPM to run properly on docker
RUN sed -i "/listen = .*/c\listen = [::]:9000" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "/;access.log = .*/c\access.log = /proc/self/fd/2" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "/;clear_env = .*/c\clear_env = no" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "/;catch_workers_output = .*/c\catch_workers_output = yes" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "/pid = .*/c\pid = /var/run/php7.2-fpm.pid" /usr/local/etc/php-fpm.conf \
    && sed -i "/;daemonize = .*/c\daemonize = no" /usr/local/etc/php-fpm.conf \
    && sed -i "/error_log = .*/c\error_log = /proc/self/fd/2" /usr/local/etc/php-fpm.conf

# The following runs FPM and removes all its extraneous log output on top of what your app outputs to stdout
CMD php-fpm -F -O 2>&1 | sed -u 's,.*: \"\(.*\)$,\1,'| sed -u 's,"$,,' 1>&1

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*;

ENV IN_CONTAINER 'yep'

ENV DEBIAN_FRONTEND teletype
