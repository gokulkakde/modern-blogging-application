FROM php:8.2-apache

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Configure PHP settings for file uploads
RUN echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 12M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 128M" >> /usr/local/etc/php/conf.d/uploads.ini

# Copy application files
COPY . /var/www/html/

# Set appropriate directory permissions for image uploads
RUN chown -R www-data:www-data /var/www/html/images \
    && chmod -R 775 /var/www/html/images

# Expose default port
EXPOSE 80

# Configure Apache to listen to $PORT if set (for Render / Railway / Heroku / Fly.io)
CMD sed -i "s/80/${PORT:-80}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf && apache2-foreground
