FROM php:8.2.9-fpm-alpine3.18
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

RUN apk update && apk add --no-cache \
     libjpeg-turbo-dev \
     libpng-dev \
     freetype-dev && \
     docker-php-ext-configure gd --with-freetype --with-jpeg && \
     docker-php-ext-install gd

RUN echo "upload_max_filesize=10M" > /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size=12M" > /usr/local/etc/php/conf.d/post.ini

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

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose порт для PHP-FPM
EXPOSE 9000
