FROM php:8.3.7-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        git \
        zlib1g-dev \
        libzip-dev \
        libicu-dev \
        libxml2-dev \
        libpq-dev \
        supervisor \
        curl \
        unzip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mysqli zip bcmath \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache

# Install heif-convert
RUN apt-get update \
    && apt-get install -y libheif-examples

# ========= ДОБАВЛЕНО: imagick с поддержкой HEIC/HEIF =========
# Установка зависимостей для сборки ImageMagick с HEIF
RUN apt-get update && apt-get install -y \
        libheif-dev \
        libde265-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libwebp-dev \
        libtiff-dev \
        build-essential \
        autoconf \
        automake \
        libtool \
        pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Сборка ImageMagick из исходников с поддержкой HEIF
RUN cd /tmp \
    && git clone https://github.com/ImageMagick/ImageMagick.git --depth 1 \
    && cd ImageMagick \
    && ./configure \
        --prefix=/usr/local \
        --with-heic=yes \
        --with-modules \
        --enable-shared \
        --disable-static \
        --with-quantum-depth=16 \
    && make \
    && make install \
    && ldconfig \
    && rm -rf /tmp/ImageMagick

# Установка PHP-расширения imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick
# =============================================================

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

COPY config/php.ini /usr/local/etc/php/php.ini

EXPOSE 9000

WORKDIR /var/www

ENV PATH=$PATH:/var/www/vendor/bin

CMD ["/usr/bin/supervisord", "-n"]
