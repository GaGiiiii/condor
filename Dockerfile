FROM php:8.0-fpm

EXPOSE 9000

#Set working directory
WORKDIR /var/www/html/condor

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get --allow-releaseinfo-change update -y && apt-get install -y \
    build-essential \
    libgmp-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    iputils-ping \
    net-tools \
    libpng-dev \
    libssl-dev \
    apt-utils \
    vim \
    nano \
    curl \
    supervisor \
    wget \
    git \
    bash \
    cron \
    libjxr0 \
    libjxr-tools \
    libmcrypt-dev \
    imagemagick \
    libzip-dev \
    libonig-dev \
    libxml2-dev

# Extensions
RUN apt-get update -y && \
    docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    mbstring \
    intl \
    xml 

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/* && \
    printf "\n" | pecl install imagick && \
    docker-php-ext-enable imagick

COPY --chown=www-data:www-data . .

RUN chmod -R 777 /var/www/html/condor/storage
RUN composer i
RUN composer dump-autoload