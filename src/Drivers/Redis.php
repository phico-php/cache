<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;

use Predis\Client;


class Redis implements Driver
{
    protected Client $client;
    protected int $ttl = 3600;


    public function __construct(array $config)
    {
        $this->client = new Client($config);
        $this->client->connect();
    }
    public function delete(string $key): bool
    {
        return $this->client->del($key) > 0;
    }
    public function exists(string $key): bool
    {
        return (bool) $this->client->exists($key);
    }
    public function set(string $key, mixed $value): self
    {
        $this->client->setex($key, $this->ttl, $value);
        return $this;
    }
    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->exists($key)) {
            return $this->client->get($key);
        }

        return $default;
    }
    public function ttl(int $seconds): self
    {
        $this->ttl = $seconds;
        return $this;
    }
}
