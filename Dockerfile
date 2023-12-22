# Build front end
FROM php:8.2 as node-build

WORKDIR /app

RUN apt update && \
    apt upgrade -y && \
    apt install -y ca-certificates cron curl git tar unzip libpng-dev libxml2-dev libzip-dev wget && \
    apt clean && \
    docker-php-ext-configure zip && \
    docker-php-ext-install bcmath gd pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash

RUN . ~/.bashrc && nvm install 18

COPY . ./

RUN composer install
RUN . ~/.bashrc && npm install

# Runner
FROM php:8.2

WORKDIR /app

RUN apt update && \
    apt upgrade -y && \
    apt install -y ca-certificates cron curl git tar unzip libpng-dev libxml2-dev libzip-dev wget && \
    apt clean && \
    docker-php-ext-configure zip && \
    docker-php-ext-install bcmath gd pdo_mysql zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . ./
COPY --from=node-build /app/public/build public/build

RUN composer install --optimize-autoloader
RUN chmod +x entrypoint.sh
RUN chmod +x entrypoint_queue.sh
RUN chmod -R 755 public/build

EXPOSE 8000
EXPOSE 9003
