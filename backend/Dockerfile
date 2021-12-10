FROM php:8.0-apache

ARG debug

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions pdo_pgsql

COPY db /var/www/db
COPY src /var/www/src
COPY vendor /var/www/vendor
COPY web /var/www/html
COPY assets /var/www/assets

CMD php -f /var/www/src/entrypoint.php -- migrate-db structures && apache2-foreground