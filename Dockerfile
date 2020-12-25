FROM existenz/webstack:7.3

COPY --chown=php:nginx . /www

RUN apk -U --no-cache add \
    php-bcmath \
        php-cli \
        php-ctype \
        php-curl \
        php-dom \
        php-fileinfo \
        php-gd \
        php-iconv \
        php-intl \
        php-json \
        php-mbstring \
        php-openssl \
        php-opcache \
        php-pdo_pgsql \
        php-phar \
        php-session \
        php-simplexml \
        php-tokenizer \
        php-xml \
        php-xmlreader \
        php-xmlwriter \
        php-zip

EXPOSE 80
