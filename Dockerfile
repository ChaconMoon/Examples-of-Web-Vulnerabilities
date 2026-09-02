FROM php:8.2-apache

# Install MySQL and PDO extensions for PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files to Apache root
COPY . /var/www/html/

RUN apt-get update && apt-get install -y git

# Set permissions for the web server user so it can write into the app directory
RUN chown -R www-data:www-data /var/www/html && chmod -R u+rwX /var/www/html

EXPOSE 80

