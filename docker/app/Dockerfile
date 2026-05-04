FROM php:8.1-fpm-bullseye

ENV TZ=Europe/Lisbon
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y \
    iputils-ping \
    net-tools \
    git \
    curl \
    openssl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libssl-dev \
    libicu-dev \
    libpq-dev \
    libpcre3-dev \
    vim \
    nano \
    supervisor \
    cron \
    rsyslog

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

RUN docker-php-ext-install intl mbstring pcntl pdo_mysql pdo_pgsql pgsql zip bcmath gd calendar \
    && docker-php-ext-configure gd --enable-gd \
    && docker-php-ext-configure calendar

RUN pecl install xdebug-3.2.2 redis \
    && docker-php-ext-enable xdebug redis

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/pear

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN mkdir -p /root/.ssh && chmod 0700 /root/.ssh

COPY ./docker/app/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html/alfasoft

COPY ./docker/app/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
