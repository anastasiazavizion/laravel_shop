web: vendor/bin/heroku-php-apache2 public/
tasks: php artisan migrate --force  && php artisan queue:work --queue=default,wishlist,wishlist-notifications,listeners,admin-mail,admin-telegram --sleep=3 --tries=3 --max-time=3600 && php artisan reverb:start
