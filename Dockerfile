FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update -y && apt-get upgrade -y
RUN apt-get install -y git curl zip libzip-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

COPY . .

USER root

RUN npm install
RUN composer install

RUN mkdir -p var/log var/cache public/build
RUN chown -R www-data:www-data /var/www

RUN npm run build

CMD ["php-fpm", "-F"]