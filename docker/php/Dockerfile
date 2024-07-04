FROM php:8.3.4-fpm-alpine3.19

ENV TZ=${TZ:-UTC}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN set -eux \
  && apk add --no-cache \
  git vim zip unzip bash curl tzdata icu-libs \
  c-client make ca-certificates imap gmp gettext libssh2 yaml \
  libintl libxslt libpng libwebp libjpeg-turbo freetype imap \
  linux-headers oniguruma libxslt libpq vips \
  gmp libzip libxml2 freetds

RUN set -eux \
  && apk add --no-cache --virtual .build_deps \
  libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev imap-dev \
  linux-headers oniguruma-dev libxslt-dev postgresql-dev vips-dev \
  libssh2-dev gmp-dev libzip-dev libxml2-dev freetds-dev yaml-dev \
  $PHPIZE_DEPS \
  && docker-php-ext-install mysqli pdo_mysql pdo_pgsql pgsql bcmath mbstring xml gd exif zip soap intl xsl pcntl sockets sysvmsg sysvsem sysvshm opcache imap gmp \
  && pecl install -o -f apcu \
  && docker-php-ext-enable apcu \
  && pecl install -o -f ssh2 \
  && docker-php-ext-enable ssh2 \
  && rm -rf /tmp/pear \
  && docker-php-source delete \
  && apk del --purge .build_deps \
  && rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY ./php.ini ${PHP_INI_DIR}/conf.d/99-php.ini

COPY ./entrypoint /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENV WORKDIR=/var/www
RUN mkdir -p ${WORKDIR}
WORKDIR ${WORKDIR}

EXPOSE 9000

CMD ["docker-entrypoint"]
