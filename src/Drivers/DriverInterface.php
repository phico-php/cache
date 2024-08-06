<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;

interface DriverInterface
{
    public function getKey(string $key): string;
    public function delete(string $key): bool;
    public function exists(string $key): bool;
    public function set(string $key, mixed $value): self;
    public function get(string $key, mixed $default = null): mixed;
    public function prefix(string $prefix): self;
    public function ttl(int $seconds): self;
}
