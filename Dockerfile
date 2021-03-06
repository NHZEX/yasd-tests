FROM phpswoole/swoole:4.6.4-php7.4

ADD yasd-7f00cb8a.tar.gz /tmp
RUN set -eux \
    && sed -i "s@http://deb.debian.org@http://mirrors.tuna.tsinghua.edu.cn@g" /etc/apt/sources.list \
    && apt update \
    && apt install libboost-all-dev -y \
    && docker-php-source extract \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql \
    && php -v \
    && php -m \
    # yasd
    && cd /tmp/yasd-master \
    && phpize \
    && ./configure \
    && make \
    && make install \
    # clean
    && docker-php-source delete \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

ENV PHP_VARS /usr/local/etc/php/conf.d/docker-vars.ini

WORKDIR /opt/serv
COPY . /opt/serv
COPY .env /opt/serv

RUN set -eux \
    && rm -rf .runtime yasd-7f00cb8a.zip \
    && mkdir .runtime \
    && composer install --prefer-dist --no-progress --no-dev

RUN set -eux \
    && echo "variables_order = \"EGPCS\""  >> ${PHP_VARS} \
    && echo "memory_limit = 256M"  >> ${PHP_VARS} \
    && chmod +x /opt/serv/imi_run.sh \
    && touch .env

ENV DEBUG_HOST 192.168.10.1
ENV DEBUG_PORT 9000

ENTRYPOINT "/opt/serv/imi_run.sh"
CMD []