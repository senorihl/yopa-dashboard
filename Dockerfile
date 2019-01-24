FROM php:7.2-fpm
LABEL maintainer="senorihl <senorihl@gmail.com>"

ENV NODE_VERSION 10.15.0
ENV PATH /usr/src/app/bin:/usr/src/app/bin:/usr/src/app/node_modules/.bin:$PATH
ENV TIMEZONE UTC

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer

RUN set -eux \
    && apt-get update \
    && apt-get install -y curl git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip zlib1g-dev libicu-dev g++ gnupg gnupg1 gnupg2 libpq-dev

RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_pgsql zip iconv intl opcache mbstring \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "date.timezone=$TIMEZONE" >> /usr/local/etc/php/php.ini \
    && echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -s -o "/usr/local/src/node-v${NODE_VERSION}-linux-x64.tar.xz" "https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.xz" \
    && mkdir -m 0755 "/usr/local/src/node-v${NODE_VERSION}-linux-x64" \
    && tar -xf "/usr/local/src/node-v${NODE_VERSION}-linux-x64.tar.xz" -C '/usr/local/src/' \
    && ln -sf "/usr/local/src/node-v${NODE_VERSION}-linux-x64/bin/node" /usr/local/bin/node \
    && ln -sf "/usr/local/src/node-v${NODE_VERSION}-linux-x64/bin/npm" /usr/local/bin/npm \
    && /usr/local/bin/npm install --global yarn \
    && ln -sf "/usr/local/src/node-v${NODE_VERSION}-linux-x64/bin/yarn" /usr/local/bin/yarn

RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m

RUN mkdir -m 0700 /usr/src/app \
    && chown dev:dev /usr/src/app

USER dev

RUN mkdir -p /home/dev/.composer/cache

WORKDIR /usr/src/app

VOLUME /home/dev/.composer/cache
