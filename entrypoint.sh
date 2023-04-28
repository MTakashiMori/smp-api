#!/bin/sh

echo "************** Installing Laravel dependencies **************"

composer install --ignore-platform-reqs --verbose

echo "************** All dependencies has been installed! **************"

sleep 2

if [[ -e .env ]]
then
    echo "************** Refreshing database **************"
    php artisan migrate:refresh --seed
else
    echo "************** Copying .env **************"
    cp .env.example .env
    echo "************** Refreshing database **************"
    php artisan migrate:refresh --seed
fi

echo "************** Generating key and refreshing  **************"
php artisan key:generate
php artisan config:cache

echo "************** Congratulations! Your application is ready to use ! **************"

exec "$@"
