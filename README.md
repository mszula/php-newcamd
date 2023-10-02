# PHP Newcamd Client

Newcamd cardserver client implementation in PHP.

## Installation

Use [Composer](https://getcomposer.org/) to install Newcamd.

```bash
$ composer require mszula/php-newcamd:dev-master
```

## Requirements

- PHP >= 5.4

## Basic Usage

Just create `Newcamd/Client` with `Newcamd/Config` argument and `connect()` to server.

```php
<?php

use Newcamd\Client;
use Newcamd\Config;

require 'vendor/autoload.php';

$config = new Config();
$config->setHost('127.0.0.1')->setPort('123456')->setDesKey('0102030405060708091011121314')
    ->setUsername('test')->setPassword('test');
    
$newcamd = new Client($config);
$newcamd->connect()
    ->login();
```

## To Do list

- Clear code
- EMM
- ECM
- CW

## License

PHP Newcamd is licensed under the MIT License - see the [License File](LICENSE.md) file for details.

## Fresh implementation in TypeScript

Hey! I haven't been here for a long time. In the meantime, I also created a TypeScript implementation of Newcamd. Feel free to use, clone, leave the star or whatever you want 😄

[https://github.com/mszula/newcamd-client](https://github.com/mszula/newcamd-client)
