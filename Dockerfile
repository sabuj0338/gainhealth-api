# Use official PHP image with Apache
FROM php:8.2-apache

# Install PHP extensions and required tools
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set up Apache config for Lumen routing
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
</Directory>" >> /etc/apache2/apache2.conf
