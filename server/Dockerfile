FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev postgresql-client git curl unzip \
 && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .
RUN composer install --no-dev --optimize-autoloader
RUN chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 8080
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
