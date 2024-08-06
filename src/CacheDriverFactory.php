<?php

declare(strict_types=1);

namespace Phico\Cache;

use Phico\Cache\Drivers\{Driver, Filesystem, Redis};

class CacheDriverFactory
{
    public static function create(array $config): Driver
    {
        $driver = $config['driver'] ?? 'files';

        return match (strtolower($driver)) {
            'redis' => new Redis($config),
            'file', 'files', 'filesystem' => new Filesystem($config),
            default => throw new \InvalidArgumentException("Unsupported driver '$driver'"),
        };
    }
}
