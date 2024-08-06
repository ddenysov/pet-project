FROM php:8.2.9-cli-alpine3.18
LABEL authors="dmytro.denysov"

WORKDIR /var/www/html

# GIT
RUN apk add git
RUN git config --global user.email "you@example.com"
RUN git config --global user.name "Dmytro Denysov"

# OS LIBS
RUN apk add postgresql-dev
RUN apk add openssl

# LIBS
RUN docker-php-ext-install pgsql pdo pdo_pgsql

# SYMFONY
RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

ENV GIT_SSL_NO_VERIFY=true
RUN apk add --update --no-cache less

RUN apk add autoconf g++ librdkafka-dev make


RUN pecl install rdkafka && docker-php-ext-enable rdkafka

CMD ["symfony", "server:start"]
