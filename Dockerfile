FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install intl pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code source de l'application
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html

RUB  composer install

SHELL ["/bin/bash", "-c"]
