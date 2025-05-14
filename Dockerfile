FROM php:8.0-apache

# Install required tools and PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli

# Copy the application source code to the Apache document root
COPY src/ /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Ensure the uploads directory exists and set permissions
RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads

# Enable Apache mod_rewrite and headers
RUN a2enmod rewrite headers

# Add caching headers for static files
RUN echo '<IfModule mod_headers.c>\n\
    <FilesMatch "\.(css|js|jpg|jpeg|png|gif|ico)$">\n\
        Header set Cache-Control "max-age=86400, public"\n\
    </FilesMatch>\n\
</IfModule>' > /etc/apache2/conf-available/cache-headers.conf && \
    a2enconf cache-headers

# Set the ServerName directive to suppress warnings
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && a2enconf servername

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]