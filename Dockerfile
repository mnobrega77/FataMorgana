# Dockerfile
FROM php:8.2

RUN apt-get update -y && apt-get install -y \
    libmcrypt-dev \
    zlib1g-dev \
    libzip-dev 


# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo  

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

# copy everything in the project into the container. This is what
# makes this image so fast!
COPY . /app

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --ignore-platform-req=ext-xsl

EXPOSE 8000
CMD ["/usr/bin/symfony", "local:server:start" , "--port=8000", "--no-tls"]
