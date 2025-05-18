FROM ghcr.io/roadrunner-server/roadrunner:2024 as roadrunner

FROM php:8.3-alpine

RUN --mount=type=bind,from=mlocati/php-extension-installer:2,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions @composer-2 opcache zip intl sockets protobuf

RUN apk add --no-cache ffmpeg

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

EXPOSE 8080/tcp

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy composer files from app directory to install dependencies
COPY ./composer.* .

RUN composer install --optimize-autoloader --no-dev
RUN ./vendor/bin/rr get-binary

# Copy application files
COPY . .

# Run RoadRunner server
#CMD ./rr serve -c .rr.yaml
CMD ["rr", "serve", "-c", ".rr.yaml"]
