FROM php:8.3-fpm

ARG user=luis
ARG uid=1000

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    postgresql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        sockets \
        intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria usuário e diretório home
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Instala o Xdebug, mas deixa desativado por padrão
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Ativa OPCache
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Define diretório de trabalho e copia a aplicação
WORKDIR /var/www
COPY . .

# Define permissões
RUN chown -R $user:www-data /var/www

USER $user
