<?php

use Phico\Cache\CacheDriverFactory;
use Phico\Cache\Drivers\Redis;
use Phico\Cache\Drivers\Filesystem;

$config = [

    'use' => '',

    'drivers' => [

        'files' => [
            'path' => '/storage/cache',
            'prefix' => '',
        ],

        'redis' => [
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
            'prefix' => '',
        ],

    ],
];

test('it can create a redis driver', function () use ($config) {
    $config['use'] = 'redis';
    $driver = CacheDriverFactory::create($config);

    expect($driver)->toBeInstanceOf(Redis::class);
});

test('it can create a file driver', function () use ($config) {
    $config['use'] = 'files';
    $driver = CacheDriverFactory::create($config);

    expect($driver)->toBeInstanceOf(Filesystem::class);
});
