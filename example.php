<?php

// load composers autoloader
require __DIR__ . '/vendor/autoload.php';

// create a configuration as array
$config = [
    'name' => 'sample configuration',
    'database' => [
        'server'   => 'localhost',
        'password' => 'password',
        'database' => 'blah',
        'type'     => 'sqlite'
    ],
    'components' => [
        'session' => new stdClass(),
        'debugger' => new stdClass()
    ]
];

// create instance of Dotor and set your configuration
$config = new \Dotor\Dotor($config);

// get name
var_dump( $config->get('name') ); // sampe configuration

// get database server
var_dump(  $config->get('database.server') ); // localhost

// get databse username and using a default value if it is not set
var_dump(  $config->get('database.username', 'root') ); // root

// get session component
var_dump( $config->get('components.session') ); // stdClass()

// get not existing value
var_dump( $config->get('blah') ); // null

// get not existing value by using default value
var_dump( $config->get('blah', 404) ); // 404