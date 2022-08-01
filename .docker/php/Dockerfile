FROM php:8.0.2-fpm-alpine

RUN apk update; \
    apk upgrade;

RUN apk add git gmp gmp-dev unzip zip nodejs yarn lsof

RUN curl -sSk https://getcomposer.org/installer | php -- --version=2.1.3 --disable-tls && \
    mv composer.phar /usr/local/bin/composer
