# Laravel TDD (Test Driven Developement) API Development

### Step by step

Clone this Repository

```sh
git clone https://github.com/tushar5334/laravel-tdd-api-development.git
```

```sh
cd laravel-tdd-api-development/
```

Install project dependencies

```sh
composer install
```

After installation

Check for "phpunit.xml" file in project root folder and uncomment below variables

```sh
<!-- <server name="DB_CONNECTION" value="sqlite"/> -->
<!-- <server name="DB_DATABASE" value=":memory:"/> -->
```

Run test

```sh
vendor/bin/phpunit
```

Command to create custom Feature test file in "tests/Feature" folder

```sh
php artisan make:test TodoListTest
```

Command to create custom Unit test file in "tests/Unit" folder

```sh
php artisan make:test TodoListTest --unit
```

To check functionality with live database

```sh
cp .env.example .env
```

Update environment variables in .env

```dosini

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=<db-name>
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>
```

Migrate database

```sh
php artisan migrate
```

Server project to localhost

```sh
php artisan serve
```

Access the project
[http://127.0.0.1:8000/api/todo-list](http://127.0.0.1:8000/api/todo-list)
