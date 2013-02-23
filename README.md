[![Build Status](https://travis-ci.org/pklink/dotor.png?branch=master)](https://travis-ci.org/pklink/dotor)

# Dotor

Dotor is a simple library for PHP 5.3 and higher to access an array by using dot notification. This can be useful for handling array configurations or so…

## Installation

Install Dotor with [Composer](http://getcomposer.org/)

Create or update your `composer.json`

```json
{
    "require": {
        "pklink/dotor": "0.*"
    }
}
```

And run Composer

```sh
php composer.phar install
```

Finally include Composers autoloader

```php
include __DIR__ . '/vendor/autoload.php';
```

## Usage

Using `Dotor is very simple. Create an instance with your (configurarion) array...

```php
$config = new \Dotor\Dotor([
    'name' => 'sample configuration',
    'database' => [
        'server'   => 'localhost',
        'username' => 'root',
        'password' => 'password',
        'database' => 'blah',
        'type'     => 'sqlite'
    ],
    'object' => new stdClass()
]);
```

... and get the content by the `get()`-method.

```php
$config->get('name');
$config->get('database.server');
```

You can find more examples in the *example.php*

### Default values

```php
$config->get('asdasdas'); // returns null
$config->get('asdasdas', 'blah'); // returns 'blah'
```

### Scalar values

```php
$config->get('object'); // returns ''
$config->get('object', 'blah'); // returns 'blah'
$config->get('not-existing'); // returns ''
$config->get('not-existing', []); // throw InvalidArgumentException
```

## Run tests

```bash
php composer.phar install --dev
php vendor/bin/phpunit tests/
```

or with code-coverage-report

```bash
php composer.phar install --dev
php vendor/bin/phpunit --coverage-html output tests/
```

## License

This package is licensed under the BSD 2-Clause License. See the LICENSE file for details.

## Credits

This package is inspired by [php-dotty](https://github.com/thesmart/php-dotty)