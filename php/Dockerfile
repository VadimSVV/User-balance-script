# Использую официальный образ PHP
FROM php:7.4-apache

# Копирую файлы проекта в рабочую директорию контейнера
COPY . /var/www/html

# Устанавливаю расширение PDO для работы с базой данных
RUN docker-php-ext-install pdo pdo_mysql

# Открываю порт 80 для веб-сервера Apache
EXPOSE 80

# Запускаю веб-сервер Apache при старте контейнера
CMD ["apache2-foreground"]