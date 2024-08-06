<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;

interface Driver
{
    public function delete(string $key): bool;
    public function exists(string $key): bool;
    public function set(string $key, mixed $value): Driver;
    public function get(string $key, mixed $default = null): mixed;
    public function ttl(int $seconds): self;
}
