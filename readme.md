## Deploy
clone this repository

run:

```
composer install

php artisan cache:clear 
chmod -R 775 storage/
composer dump-autoload

php artisan key:generate
php artisan migrate
php artisan passport:keys

npm i
```