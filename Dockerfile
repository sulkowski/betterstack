FROM php:8.3-fpm-alpine

RUN docker-php-ext-install mysqli

RUN addgroup -g 1000 appuser \
 && adduser -u 1000 -G appuser -s /bin/sh -D appuser

WORKDIR /var/www/html

COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini

COPY --chown=appuser:appuser . .

USER appuser
