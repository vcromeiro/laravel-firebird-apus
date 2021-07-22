# Firebird for Laravel

[![Latest Stable Version](https://poser.pugx.org/vcromeiro/laravel-firebird/v/stable)](https://packagist.org/packages/vcromeiro/laravel-firebird)
[![Total Downloads](https://poser.pugx.org/vcromeiro/laravel-firebird/downloads)](https://packagist.org/packages/vcromeiro/laravel-firebird)
[![License](https://poser.pugx.org/vcromeiro/laravel-firebird/license)](https://packagist.org/packages/vcromeiro/laravel-firebird)

This package adds support for the Firebird PDO driver in Laravel applications. Support for Laravel 5.5 to 8.x with PHP 7.1+ and Firebird 1.5 or 2.5

## Installation

You can install the package via composer:

```json
composer require vcromeiro/laravel-firebird
```

_The package will automatically register itself._

Declare the connection within your `config/database.php` file, using `firebird` as the
driver:
```php
'connections' => [

    'firebird' => [
        'driver'   => 'firebird',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', '3050'),
        'database' => env('DB_DATABASE', '/path_to/database.fdb'),
        'username' => env('DB_USERNAME', 'sysdba'),
        'password' => env('DB_PASSWORD', 'masterkey'),
        'charset'  => env('DB_CHARSET', 'UTF8'),
        'version'  => env('DB_VERSION', '2.5'), // Supported versions: 2.5, 1.5
        'role'     => null,
    ],

],
```

To register this package in Lumen, you'll also need to add the following line to the service providers in your `config/app.php` file:
`$app->register(\Firebird\FirebirdServiceProvider::class);`

## Limitations
This package does not support database migrations and it should not be used for this use case.

## Credits
This package was originally forked from [acquestvanzuydam/laravel-firebird](https://github.com/jacquestvanzuydam/laravel-firebird) with enhancements from [sim1984/laravel-firebird](https://github.com/sim1984/laravel-firebird) and [harrygulliford/laravel-firebird](https://github.com/harrygulliford/laravel-firebird).

## License
Licensed under the [MIT](https://choosealicense.com/licenses/mit/) licence.
