<?php

use Phico\Cache\Drivers\Filesystem;

$path = 'tests/fixtures/cache';

beforeEach(function () use ($path) {
    $this->driver = new Filesystem(['path' => $path]);
    folders($path)->create();
});

afterEach(function () use ($path) {
    array_map('unlink', glob(path("$path/*")));
    rmdir(path($path));
});

test('it can set and get a value in file cache', function () {
    $this->driver->set('foo', 'bar');
    expect($this->driver->get('foo'))->toBe('bar');
});

test('it returns default value if key does not exist in file cache', function () {
    expect($this->driver->get('foo', 'default'))->toBe('default');
});

test('it can delete a value in file cache', function () {
    $this->driver->set('foo', 'bar');
    expect($this->driver->delete('foo'))->toBeTrue();
    expect($this->driver->exists('foo'))->toBeFalse();
});
