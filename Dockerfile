FROM php:7.1-cli-stretch

#install some base extensions
RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        zip \
  && docker-php-ext-install zip
