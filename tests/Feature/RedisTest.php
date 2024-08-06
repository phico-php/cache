<?php

use Phico\Cache\Drivers\Redis;

beforeEach(function () {
    $this->driver = new Redis(['host' => '127.0.0.1', 'port' => 6379]);
});

test('it can set and get a value in redis cache', function () {
    $this->driver->set('foo', 'bar');
    expect($this->driver->get('foo'))->toBe('bar');
});

test('it returns default value if key does not exist in redis cache', function () {
    expect($this->driver->get('bar', 'default'))->toBe('default');
});

test('it can delete a value in redis cache', function () {
    expect($this->driver->delete('foo'))->toBeTrue();
});
