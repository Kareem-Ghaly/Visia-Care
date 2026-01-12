FROM webdevops/php-nginx:8.2-alpine

WORKDIR /app
ENV WEB_DOCUMENT_ROOT=/app/public

RUN apk update && apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpq \
    libpq-dev \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY . /app
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 storage bootstrap/cache && \
    chown -R application:application /app

EXPOSE 80

CMD ["/entrypoint", "supervisord"]
