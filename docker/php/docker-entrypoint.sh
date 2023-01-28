#!/bin/bash
set -e

if [ -f composer.json ]; then
    composer install 
fi

bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
bin/console app:load-github

exec "$@"

exec "php-fpm"