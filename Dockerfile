FROM webdevops/php-nginx:8.2-alpine

WORKDIR /app
ENV WEB_DOCUMENT_ROOT=/app/public

# تثبيت الأدوات + دعم MySQL (mariadb-dev)
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    mariadb-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# نسخ ملفات المشروع
COPY . /app

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# تثبيت باكجات PHP بدون dev
RUN composer install --no-dev --optimize-autoloader

# ضبط الصلاحيات
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R application:application /app

EXPOSE 80

# تشغيل nginx + php-fpm
CMD ["/entrypoint", "supervisord"]
