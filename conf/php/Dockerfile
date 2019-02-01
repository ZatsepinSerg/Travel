FROM php:7.2-fpm

RUN apt-get update

RUN apt-get install -y curl libcurl4-openssl-dev
RUN docker-php-ext-install curl
RUN docker-php-ext-enable curl
   
