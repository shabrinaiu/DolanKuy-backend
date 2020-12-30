FROM composer:2 as vendor

COPY . .

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-progress \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    && find /app -type d -exec chmod -R 555 {} \; \
    && find /app -type f -exec chmod -R 444 {} \; \
    && find /app/storage -type d -exec chmod -R 755 {} \; \
    && find /app/storage -type f -exec chmod -R 644 {} \;

RUN composer dump-autoload

FROM existenz/webstack:7.3

EXPOSE 80
EXPOSE 443

COPY --from=vendor --chown=php:nginx /app /www

# https://github.com/docker-library/php/issues/240
RUN apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN apk -U --no-cache add \
    php7 php7-zip php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-xmlwriter php7-ctype \
    php7-mbstring php7-gd php7-session php7-pdo php7-pdo_mysql php7-tokenizer php7-posix \
    php7-fileinfo php7-opcache php7-cli php7-mcrypt php7-pcntl php7-iconv php7-simplexml
