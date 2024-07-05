# Используем официальный образ PHP 8
FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Установка PHP-расширений
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создание рабочей директории
WORKDIR /var/www

# Копирование файлов проекта
COPY . .

# Установка зависимостей проекта
RUN composer install --no-scripts --no-autoloader
RUN composer dump-autoload --optimize

# Права на запись для хранения и кеша
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Запуск
CMD ["php-fpm"]
