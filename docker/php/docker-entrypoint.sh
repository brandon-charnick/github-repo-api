#!/bin/bash
set -e

if [ -f composer.json ]; then
    if [ -d vendor ]; then
        rm -r vendor
    fi
    if [ -d var ]; then
        rm -r var
    fi
    composer install 
fi

bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
bin/console app:load-github

exec "$@"

exec "php-fpm"