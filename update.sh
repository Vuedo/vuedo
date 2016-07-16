#!/bin/bash;
echo "Updating...";

echo "Install project dependencies...";
composer install
npm install

echo "Migrate and seed the database...";
php artisan migrate:refresh
php artisan db:seed

echo "You are ready to go!";