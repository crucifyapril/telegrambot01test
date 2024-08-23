# Используем официальный образ PHP
FROM php:8.3-fpm

# Устанавливаем необходимые расширения PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Устанавливаем необходимые инструменты
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем исходный код бота в контейнер
#COPY . /usr/src/myapp
WORKDIR /app

# Устанавливаем зависимости Composer
#RUN composer install

# Запускаем бота
# CMD [ "php", "./bot.php" ]