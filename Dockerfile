FROM php:7.2-fpm

RUN apt-get update \
  && apt-get install --no-install-recommends -y libpq-dev \
  && docker-php-ext-install pgsql \
  && docker-php-ext-install pdo pdo_pgsql \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql