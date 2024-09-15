FROM php:8.1-fpm

# 安裝必要的 PHP 擴展
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql xml

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 設置工作目錄
WORKDIR /var/www/html

# 複製當前目錄到容器
COPY . .

# 設置文件權限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html

# 安裝 PHP 依賴
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 for php-fpm
EXPOSE 9000

CMD ["php-fpm"]
