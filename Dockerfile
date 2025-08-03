ARG PHP_VERSION=8.4.8

# Etapa 1: Node base para instalación previa (opcional)
FROM node:20.12.2-slim AS node-builder

WORKDIR /app

COPY package.json ./
RUN npm install && npm rebuild

# Etapa 2: Preparar Laravel con Composer y Flux
FROM php:${PHP_VERSION}-fpm-alpine AS builder

WORKDIR /var/www/html

# Dependencias del sistema y PHP
RUN apk add --no-cache \
    autoconf \
    bash \
    build-base \
    curl \
    freetype-dev \
    git \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    unzip \
    zip \
    mariadb-client \
    icu-dev \
    pkgconf


# Configurar e instalar extensiones PHP (incluye gd con freetype y jpeg)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    intl \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    mbstring \
    bcmath \
    xml \
    pcntl \
    zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Archivos composer y auth.json
COPY composer.json composer.lock auth.json ./

# Configurar repositorio privado y dependencias PHP
RUN composer config repositories.flux-pro composer https://composer.fluxui.dev \
    && composer config http-basic.composer.fluxui.dev ransessanchez1506@gmail.com c23cd330-dce4-4bb1-90e2-54b3c2306759 \
    && composer install --no-dev --prefer-dist --no-scripts --no-autoloader

# Copiar el resto del proyecto
COPY . .

# Instalar Flux
RUN composer require livewire/flux-pro

# Etapa 3: Build de frontend + Puppeteer + Chromium
FROM node:20.12.2-alpine AS vite-builder

ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser

WORKDIR /app



# Copiar app desde builder PHP
COPY --from=builder /var/www/html /app

RUN npm install \
    && npm install puppeteer \
    && npm run build

# Etapa 4: Imagen final optimizada para producción
FROM php:${PHP_VERSION}-fpm-alpine

WORKDIR /var/www/html

# Dependencias mínimas necesarias en producción
RUN apk add --no-cache \
    mariadb-client \
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
    fontconfig \
    nodejs \
    npm \
    poppler-utils \
    yarn


RUN docker-php-ext-install pdo pdo_mysql

# Copiar toda la aplicación con node_modules y puppeteer desde vite-builder
COPY --from=vite-builder /app /var/www/html
RUN npm install puppeteer

# Cache Laravel
RUN php artisan config:clear \
    && php artisan route:cache \
    && php artisan view:cache

# Permisos
RUN mkdir -p /var/run/php-fpm \
    && chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
