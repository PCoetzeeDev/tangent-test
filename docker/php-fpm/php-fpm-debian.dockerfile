FROM php:8.2-fpm

# Make sure we are starting with a clean slate
RUN rm -rf /var/lib/apt/lists/* && rm -rf /etc/apt/sources.list.d/*
RUN apt-get clean
RUN apt-get update -o Acquire::CompressionTypes::Order::=gz

# Install depencies
RUN apt-get -y install \
    apt-utils \
    ca-certificates \
    openssl \
    wget \
    libgnutls30 \
    libssl-dev \
    build-essential \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmagickwand-dev \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    locales \
    curl \
    git \
    unzip

# Setup known hosts
RUN ssh-keyscan -t rsa github.com >> /etc/ssh/ssh_known_hosts

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) pdo_pgsql mbstring zip exif pcntl gd soap \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/

# Install pecl extensions
RUN pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install imagick-beta \
    && docker-php-ext-enable imagick

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install node
RUN curl -fsSL https://deb.nodesource.com/setup_19.x | bash - && apt-get install -y nodejs

# Install the xdebug extension
#RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy xdebug configuration for remote debugging
#COPY ./php-fpm/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
#    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
#    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get clean && apt-get autoremove
RUN rm -rf /var/lib/apt/lists/*
RUN apt-get update -o Acquire::CompressionTypes::Order::=gz
RUN rm -rf /tmp/*

# ARG app_user
ARG APP_USER
ENV APP_USER $APP_USER
RUN groupadd -g 1000 "$APP_USER" \
    && useradd -u 1000 -ms /bin/bash -g "${APP_USER}" "${APP_USER}"

# Change current user to local user
USER ${APP_USER}

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
