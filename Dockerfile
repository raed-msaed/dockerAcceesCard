# Use the official PHP image as the base image
FROM php:8.1.2-apache

# Set environment variables.
ENV ACCEPT_EULA=Y
LABEL maintainer="raed.hammouda.msaed@gmail.com"
# Set working directory
WORKDIR /var/www/html

# Mod Rewrite
RUN a2enmod rewrite

# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install gettext intl pdo_mysql zip

# Set the Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update the Apache configuration to point to the new document root
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2.5.8 /usr/bin/composer /usr/bin/composer

# Set environment variable for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy Composer files and install dependencies
COPY PFE_access_card/composer.json PFE_access_card/composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code
COPY PFE_access_card ./

# Generate Composer autoload files
RUN composer dump-autoload --optimize

# Ensure that the Apache configuration allows serving the directory
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Set permissions for Laravel.
RUN chown -R www-data:www-data storage bootstrap/cache

# Copy wait-for-it script to the container
COPY wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Start the Laravel application
CMD /usr/local/bin/wait-for-it.sh mysql_db:3306 -- php artisan serve --host=0.0.0.0 --port=80
