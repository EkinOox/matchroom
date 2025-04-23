FROM php:8.2-apache

WORKDIR /var/www/html

# Install extensions
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite
RUN a2enmod rewrite

# Copier et installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code Symfony
COPY . .

# Changer DocumentRoot vers /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Fixer les permissions
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/vendo

EXPOSE 80
