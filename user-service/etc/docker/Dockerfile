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

# COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# RUN cd /var/www/html && php bin/console lexik:jwt:generate-keypair
# RUN setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
# RUN setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt

# Установка порта, который будет слушать сервер
EXPOSE 8000

# Команда для запуска PHP встроенного сервера
CMD ["symfony", "server:start"]
