## Server side build
```
composer update
```

## Create .env
```
cp .env.example .env
```


## Create DB (eg. 'oldies')
## add DB config to .env
```
DB_DATABASE=oldies
DB_USERNAME=root
DB_PASSWORD=root
```

## add API_KEY to .env
```
API_KEY=JdJEeb5hB8nCiZ7nuTPMn54wb1nAUjlqWtbqcEfr
```
use it as a api token for api

## Laravel api key generate
```
php artisan key:generate
```

## DB update
```
php artisan migrate
```
creates tables

## DB seed
```
php artisan db:seed
```
fills artist and record tables rows with example data. Usefull after tests run also (tests refresh DB)

## OpenAPI doc generate
```
php artisan l5-swagger:generate
```
available at /api/documentation
(link on the welcome page)

## Run dev server
```
php artisan serve
```

