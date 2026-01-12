FROM webdevops/php-nginx:8.2-alpine

# مسار المشروع داخل الحاوية
WORKDIR /app

# نحدد مجلد public كـ document root
ENV WEB_DOCUMENT_ROOT=/app/public

# تثبيت بعض الأدوات ومكتبات PHP المطلوبة
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libpq \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# نسخ ملفات المشروع
COPY . /app

# تثبيت Composer (نسخة جاهزة من صورة composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# تثبيت باكجات PHP بدون dev لتحسين الأداء
RUN composer install --no-dev --optimize-autoloader

# تعيين صلاحيات صحيحة للمجلدات
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R application:application /app

# استخدام user غير root
USER application

# المنفذ اللي Nginx رح يسمع عليه
EXPOSE 80

# الأمر الافتراضي لتشغيل Nginx + PHP-FPM
CMD ["/entrypoint"]
