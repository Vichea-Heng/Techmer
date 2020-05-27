#!bin/bash

php artisan migrate:fresh --seed 
rm -r /Users/vichea/mamp/laravel/Techmer/storage/app/Techmer
# cp -R /Users/vichea/Desktop/Techmer /Users/vichea/mamp/laravel/Techmer/storage/app