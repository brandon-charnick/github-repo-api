#!/bin/bash
set -e

if [ -f composer.json ]; then
    composer install 
fi

exec "$@"

exec "php-fpm"