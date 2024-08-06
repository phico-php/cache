<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;

use Predis\Client;


class Redis implements DriverInterface
{
    protected Client $client;
    protected int $ttl;
    protected string $prefix;


    public function __construct(array $config)
    {
        $this->client = new Client($config);
        $this->prefix = $config['prefix'] ?? '';
        $this->ttl = $config['ttl'] ?? 3600;

        $this->client->connect();
    }
    public function __destruct()
    {
        $this->client->disconnect();
    }
    public function getKey(string $key): string
    {
        return "{$this->prefix}{$key}";
    }
    public function delete(string $key): bool
    {
        return $this->client->del($this->getKey($key)) > 0;
    }
    public function exists(string $key): bool
    {
        return (bool) $this->client->exists($this->getKey($key));
    }
    public function set(string $key, mixed $value): self
    {
        $this->client->setex($this->getKey($key), $this->ttl, $value);
        return $this;
    }
    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->exists($key)) {
            return $this->client->get($this->getKey($key));
        }

        return $default;
    }
    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;
        return $this;
    }
    public function ttl(int $seconds): self
    {
        $this->ttl = $seconds;
        return $this;
    }
}
