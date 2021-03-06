#!/bin/bash

WORKDIR="${PWD}"
echo "${WORKDIR}"

php \
 -dzend_extension=yasd \
 -dyasd.debug_mode=remote \
 -dyasd.remote_host="${DEBUG_HOST}" \
 -dyasd.remote_port="${DEBUG_PORT}" \
 --ri yasd

php -v
php -m

php \
 -dzend_extension=yasd \
 -dyasd.debug_mode=remote \
 -dyasd.remote_host="${DEBUG_HOST}" \
 -dyasd.remote_port="${DEBUG_PORT}" \
 -e ./vendor/bin/imi server/start