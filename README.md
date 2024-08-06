# Cache

Lightweight cache support for [Phico](https://github.com/phico-php/phico)

## Installation

Using composer

```sh
composer require phico/cache
```

## Config

Cache requires a specific config format for each driver

```php
[

    'use' => env('CACHE_USE', 'default'),

    'drivers' => [

        'file' => [
            'path' => env('CACHE_FILESYSTEM_PATH', '/storage/cache'),
        ],

        'redis' => [
            'scheme' => env('CACHE_REDIS_SCHEME', 'tcp'),
            'host' => env('CACHE_REDIS_HOST', '127.0.0.1'),
            'port' => env('CACHE_REDIS_PORT', 6379),
        ],

    ],
];
```

## Usage

Cache provides quick and simple access to cache servers such as Redis, KeyDB and Valkey.

```php

$use = $config['use'];
$cache = new Cache($config['drivers'][$use]);

$cache->set('foo', 'bar');
$value = $cache->get('foo');
// $value = 'bar'

$cache->delete('foo');
$exists = $cache->exists('foo'):
// $exists = false
```

## Issues

If you discover any bugs or issues with behaviour or performance please create an issue, and if you are able a pull request with a fix.

Please make sure to update tests as appropriate.

For major changes, please open an issue first to discuss what you would like to change.

## License

[BSD-3-Clause](https://choosealicense.com/licenses/bsd-3-clause/)
