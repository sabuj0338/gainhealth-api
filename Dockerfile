# Use a base image with Nginx and PHP-FPM (adjust PHP version as needed)
FROM richarvey/nginx-php-fpm:php8.2

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Install PHP dependencies
# The base image might run composer install via scripts (RUN_SCRIPTS=1 below)
# If not, uncomment the next line:
# RUN composer install --optimize-autoloader --no-dev

# Set permissions for Lumen storage/cache (adjust if needed)
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# --- Configuration for richarvey/nginx-php-fpm image ---
# Expose port 80 (Nginx default)
# EXPOSE 80 # (Usually inherited from base image)

# Set webroot to Lumen's public directory
ENV WEBROOT /var/www/html/public
# Enable error logging to stderr for Render logs
ENV PHP_ERRORS_STDERR 1
# Enable running scripts from the /scripts directory during startup
ENV RUN_SCRIPTS 1
# Allow composer to run as root if needed by scripts
ENV COMPOSER_ALLOW_SUPERUSER 1

# Laravel/Lumen specific config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Container start command (handled by the base image's /start.sh)
# CMD ["/start.sh"] # (Usually inherited)