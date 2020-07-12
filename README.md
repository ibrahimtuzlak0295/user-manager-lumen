# user-manager-lumen

## Installation

```shell
$ composer install
$ touch database/database.sqlite
$ cp .env.example .env # Leave database defaults for quick SQLite testing
$ php artisan migrate --seed # Creates a user: username: "ibrahim", password: "password"
$ php -S localhost:8000 -t public/
```
