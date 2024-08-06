<?php

declare(strict_types=1);

namespace Phico\Cache;

use Phico\Cache\Drivers\Driver;

class Cache
{
    protected Driver $driver;


    public function __construct(array $config)
    {
        $this->driver = CacheDriverFactory::create($config);
        $this->driver->ttl($config['ttl'] ?? 3600);
    }
    public function __call(string $method, array $args): mixed
    {
        return $this->driver->$method(...$args);
    }
    public function delete(string $key): bool
    {
        return $this->driver->delete($key);
    }
    public function exists(string $key): bool
    {
        return $this->driver->exists($key);
    }
    public function set(string $key, mixed $value): self
    {
        $this->driver->set($key, $value);
        return $this;
    }
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->driver->get($key, $default);
    }
    public function ttl(int $seconds): self
    {
        $this->driver->ttl($seconds);
        return $this;
    }
}
