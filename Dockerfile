FROM php:8.4-fpm AS builder

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    zlib1g-dev \
    procps \
    supervisor

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql mbstring intl zip exif sockets opcache pcntl

# Install and enable APCu and Redis
RUN pecl install apcu redis
RUN docker-php-ext-enable apcu redis

# Remove unnecessary packages
RUN rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

# Set environment variables
ENV TZ=Europe/Moscow

# Set working directory
WORKDIR /var/www/html

# Copy php.ini file without duplicate extensions
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

COPY ./docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

# Настройка размеров буфера UDP
RUN sysctl -w net.core.rmem_max=7500000
RUN sysctl -w net.core.wmem_max=7500000

# Pass user and group ID via ARG
ARG USER_ID=1000
ARG GROUP_ID=1000

# Create the appuser *before* using it
RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -u ${USER_ID} -g appuser -m appuser

# Set permissions
RUN chown -R appuser:appuser /var/www/html
RUN [ -d /var/www/html/storage/logs ] || mkdir -p /var/www/html/storage/logs && chmod -R 775 /var/www/html/storage/logs/

# Copy project files
COPY --chown=user:user . /var/www/html

# Switch user
USER appuser

# Expose port
EXPOSE 9000

# Copy supervisord configuration
COPY ./docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start supervisord to manage php-fpm services
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
