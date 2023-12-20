FROM php:8.2

WORKDIR /app

RUN apt update && \
    apt upgrade -y && \
    apt install -y ca-certificates cron curl git tar unzip libpng-dev libxml2-dev libzip-dev wget && \
    apt clean && \
    docker-php-ext-configure zip && \
    docker-php-ext-install bcmath gd pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 8000
EXPOSE 9003
