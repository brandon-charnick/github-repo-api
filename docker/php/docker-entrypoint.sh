#!/bin/bash
set -e

if [ -f composer.json ]; then
    composer install 
fi

php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
# php bin/console app:load-repos

exec "$@"

exec "php-fpm"