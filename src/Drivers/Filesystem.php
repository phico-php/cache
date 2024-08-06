<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;


class Filesystem implements Driver
{
    protected string $path;
    protected int $ttl = 3600;


    public function __construct(array $config = [])
    {
        $this->path = $config['path'] ?? 'storage/cache';
    }
    public function delete(string $key): bool
    {
        try {
            files(path("$this->path/$key"))->delete();
        } catch (\Throwable $th) {
            // throw new DriverException('Failed to delete session from store', $th);
        }

        // always return true
        return true;
    }

    public function exists(string $key): bool
    {
        try {

            $file = files(path("$this->path/$key"));

            if (!$file->exists()) {
                return false;
            }

            // get modified timestamp
            $updated_at = filemtime((string) $file);
            // handle errors fetching modified time
            if (false === $updated_at) {
                return false;
            }
            // if file updated_at is greater than ttl, it's expired
            if ((time() - $updated_at) > $this->ttl) {
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
            files(path("$this->path/$key"))->write(serialize($value));
            return $this;
        } catch (\Throwable $th) {
            throw new DriverException('Failed to store item in filesystem cache', $th);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        try {

            if ($this->exists($key)) {
                return unserialize(files(path("$this->path/$key"))->read());
            }

            return $default;

        } catch (\Throwable $th) {
            throw new DriverException('Failed to fetch item from filesystem cache', $th);
        }
    }
    public function ttl(int $seconds): self
    {
        $this->ttl = $seconds;
        return $this;
    }
}
