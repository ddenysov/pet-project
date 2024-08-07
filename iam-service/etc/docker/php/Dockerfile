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

RUN apk add --no-cache supervisor
RUN mkdir -p /var/log/supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.5.8 \
    && if [ "$DA_DEBUG" = "true" ]; then apk add --no-cache $PHPIZE_DEPS && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug; fi

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

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
