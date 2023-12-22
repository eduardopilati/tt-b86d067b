#!/bin/bash

php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan migrate --force --isolated
php artisan serve --host 0.0.0.0
