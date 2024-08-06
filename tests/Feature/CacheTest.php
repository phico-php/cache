<?php

use Phico\Cache\CacheDriverFactory;
use Phico\Cache\Drivers\Redis;
use Phico\Cache\Drivers\Filesystem;

test('it can create a redis driver', function () {
    $config = ['driver' => 'redis', 'host' => '127.0.0.1', 'port' => 6379];
    $driver = CacheDriverFactory::create($config);

    expect($driver)->toBeInstanceOf(Redis::class);
});

test('it can create a file driver', function () {
    $config = ['driver' => 'file', 'path' => __DIR__ . '/cache'];
    $driver = CacheDriverFactory::create($config);

    expect($driver)->toBeInstanceOf(Filesystem::class);
});
