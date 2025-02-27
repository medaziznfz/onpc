

### How to setup

```bash
composer install
# copy .env.example to .env
cp .env.example .env
# generate security key , link storage file
php artisan key:generate
php artisan storage:link
# after connect your database via .env file
php artisan migrate
#php artisan migrate:fresh
php artisan db:seed

```

### Credentials

```
login page : <http://127.0.0.1:8000/login>
email : 00000000 or onpc@onpc.com
password : 123456789

```


### Note

```
nothing

```