FROM composer as composer
COPY . /app
RUN composer install --ignore-platform-reqs --no-scripts

FROM node:12.7-alpine AS build
RUN mkdir -p /tmp/app && chown -R node:node /tmp/app
WORKDIR /tmp/app
COPY . /tmp/app
USER node
RUN npm install

FROM php:7.4-fpm-alpine AS runner
WORKDIR /var/www/html

# Add Build Dependencies
RUN apk add --no-cache --virtual .build-deps  \
    zlib-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    oniguruma-dev \
    bzip2-dev 

# Add Production Dependencies
RUN apk add --update --no-cache \
    jpegoptim \ 
    pngquant \ 
    optipng \
    supervisor \
    nano \
    icu-dev \
    freetype-dev 

RUN docker-php-ext-configure gd --with-freetype --with-jpeg &&\ 
    docker-php-ext-install \ 
    pdo_mysql \
    sockets \ 
    mbstring \
    json \
    intl \
    gd \
    xml \
    zip \
    bz2 \
    pcntl \
    bcmath \
    exif \ 
    zip \
    sodium

# Setup Crond and Supervisor by default
RUN echo '*  *  *  *  * /usr/local/bin/php  /var/www/artisan schedule:run' >> /dev/null

# Remove Build Dependencies
RUN apk del -f .build-deps
# Setup Working Dir
WORKDIR /var/www/html
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=build /tmp/app/node_modules /var/www/html/node_modules
