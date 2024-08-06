<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;


class Filesystem implements DriverInterface
{
    protected string $path;
    protected int $ttl;
    protected string $prefix;


    public function __construct(array $config = [])
    {
        $this->path = $config['path'] ?? 'storage/cache';
        $this->prefix = $config['prefix'] ?? '';
        $this->ttl = $config['ttl'] ?? 3600;
    }
    public function getKey(string $key): string
    {
        return path("{$this->path}/{$this->prefix}{$key}");
    }
    public function delete(string $key): bool
    {
        try {
            files($this->getKey($key))->delete();
        } catch (\Throwable $th) {
            // throw new DriverException('Failed to delete session from store', $th);
        }

        // always return true
        return true;
    }
    public function exists(string $key): bool
    {
        try {

            $file = files($this->getKey($key));

            if (!$file->exists()) {
                return false;
            }

            // if file updated_at is greater than ttl, it's expired
            if ((time() - $file->mtime()) > $this->ttl) {
                $this->delete($key);
                return false;
            }

            return true;

        } catch (\Throwable $th) {
            throw new DriverException('Failed checking existence of cached item', $th);
        }
    }
    public function set(string $key, mixed $value): self
    {
        try {
            files($this->getKey($key))->write(serialize($value));
            return $this;
        } catch (\Throwable $th) {
            throw new DriverException('Failed to store item in filesystem cache', $th);
        }
    }
    public function get(string $key, mixed $default = null): mixed
    {
        try {

            if ($this->exists($key)) {
                return unserialize(files($this->getKey($key))->read());
            }

            return $default;

        } catch (\Throwable $th) {
            throw new DriverException('Failed to fetch item from filesystem cache', $th);
        }
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
