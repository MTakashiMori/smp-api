FROM alpine:3.18 as web

# Install required system packages
RUN apk add --no-cache nginx \
    && apk add --no-cache --virtual .build-deps autoconf build-base \
    && apk add --no-cache icu-dev libzip-dev postgresql-dev \
    && rm -rf /var/lib/apt/lists/*

# Installing PHP
RUN apk add --no-cache php81 \
    php81-common \
    php81-fpm \
    php81-dev \
    php81-pdo \
    php81-opcache \
    php81-zip \
    php81-phar \
    php81-iconv \
    php81-cli \
    php81-curl \
    php81-openssl \
    php81-mbstring \
    php81-tokenizer \
    php81-fileinfo \
    php81-json \
    php81-xml \
    php81-xmlwriter \
    php81-simplexml \
    php81-dom \
    php81-pdo_mysql \
    php81-pdo_sqlite \
    php81-tokenizer \
    php81-pecl-redis \
    autoconf  \
    make  \
    gcc \
    musl-dev \
    g++

# Install Xdebug
#RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
#    && pecl install xdebug \
#    && docker-php-ext-enable xdebug

RUN php -v

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Nginx
COPY docker-files/nginx.conf /etc/nginx/nginx.conf
COPY docker-files/php.ini /etc/php/php.ini


# Expose the ports
EXPOSE 80
