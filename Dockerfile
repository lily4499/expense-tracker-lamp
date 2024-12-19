# Use an official PHP base image with Apache
FROM php:7.4-apache

# Set ServerName to avoid Apache warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install dependencies and MySQL extensions
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && docker-php-ext-install pdo_mysql mysqli

# Copy application files to the container
COPY . /var/www/html/

# Set permissions for the web server
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80 for the application
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]


