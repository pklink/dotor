# Dotor [![Build Status](https://travis-ci.org/pklink/dotor.png?branch=master)](https://travis-ci.org/pklink/dotor) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/pklink/dotor/badges/quality-score.png?s=8339e7587ee2f331e692d29a304f4e97d2455fac)](https://scrutinizer-ci.com/g/pklink/dotor/)

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
    'object' => new stdClass(),
    'false'      => false,
    'true'       => true,
    'zeroString' => '0',
    'zeroInt'    => 0,
    'oneString'  => '1',
    'oneInt'     => 1,
    'twoString'  => '2',
]);
```

... and get the content by the `get()`-method.

```php
$config->get('name');
$config->get('database.server');
```

### Default values

```php
$config->get('asdasdas');         // returns null
$config->get('asdasdas', 'blah'); // returns 'blah'
```

### Scalar values

```php
$config->getScalar('object');           // returns ''
$config->getScalar('object', 'blah');   // returns 'blah'
$config->getScalar('not-existing');     // returns ''
$config->getScalar('not-existing', []); // throw InvalidArgumentException
```

### Arrays

```php
$config->getArray('database');      // returns the database array
$config->getArray('notexit');       // returns []
$config->getArray('notexit', [1]);  // returns [1]
```

### Boolean

```php
$config->getBoolean('database', false);   // returns false
$config->getBool('database', true);       // returns true
$config->getBoolean('zeroString', true);  // returns false
$config->getBoolean('zeroInt', true);     // returns false
$config->getBoolean('oneString', false);  // returns true
$config->getBoolean('oneInt', false);     // returns true
```

The `getBoolean()`-method and their alias `getBool()` handle the string `'1'` and the integer `1` as `true`. Otherwise this
method returns the given `$default` or `true`.

```php
$config->getBoolean('oneString', false);   // returns true
$config->getBoolean('twoString', false);   // returns false
$config->getBoolean('twoString');          // returns true
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