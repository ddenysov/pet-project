FROM ghcr.io/roadrunner-server/roadrunner:2024 as roadrunner

FROM php:8.3-alpine

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        libzip-dev \
        icu-dev \
        protobuf-dev \
        bash \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Установка PHP-расширений
RUN --mount=type=bind,from=mlocati/php-extension-installer:2,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions @composer-2 opcache zip intl sockets protobuf pdo_sqlite sqlite3

# Копируем конфигурации
COPY ./conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

EXPOSE 8080/tcp

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy composer files from app directory to install dependencies
COPY ./composer.* .

# RUN composer install --optimize-autoloader --no-dev
# RUN ./vendor/bin/rr get-binary

# Copy application files
# COPY . .

# Run RoadRunner server
#CMD ./rr serve -c .rr.yaml
CMD ["rr", "serve", "-c", ".rr.yaml"]
