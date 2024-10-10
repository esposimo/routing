FROM php:8.2-fpm

RUN apt -y update -y && apt -y upgrade && \
    apt -y install git libzip-dev zip libcurl4-openssl-dev curl wget git && \
    docker-php-ext-install zip curl && \
    cd /tmp && \
    curl -k https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php && \
    mv composer.phar /usr/local/bin/composer && \
    rm -f composer-setup.php && \
    mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    addgroup --gid 1000 smn && \
    adduser --gid 1000 --uid 1000 smn