FROM webdevops/php-nginx:8.2-alpine

# مسار المشروع داخل الحاوية
WORKDIR /app

# نحدد مجلد public كـ document root
ENV WEB_DOCUMENT_ROOT=/app/public

# تثبيت الأدوات ومكتبات PostgreSQL المطلوبة
RUN apk update && apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpq \
    libpq-dev \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# نسخ ملفات المشروع
COPY . /app

# تثبيت Composer (نسخة جاهزة من صورة composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# تثبيت باكجات PHP بدون dev لتحسين الأداء
RUN composer install --no-dev --optimize-autoloader

# تعيين صلاحيات صحيحة للمجلدات
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R application:application /app

# ملاحظة مهمة:
# لا نستخدم USER application لأن Render يمنع التحويل إلى root لاحقاً
# لذلك نترك الصورة تعمل بالمستخدم الافتراضي

EXPOSE 80

# الأمر الافتراضي لتشغيل Nginx + PHP-FPM
CMD ["/entrypoint"]
