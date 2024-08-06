<?php

declare(strict_types=1);

namespace Phico\Cache;

use Phico\Cache\Drivers\{DriverInterface, Filesystem, Redis};


class CacheDriverFactory
{
    public static function create(array $config): DriverInterface
    {
        $use = strtolower($config['use']);

        return match (strtolower($use)) {
            'redis' => new Redis($config),
            'file', 'files', 'filesystem' => new Filesystem($config),
            default => throw new \InvalidArgumentException("Unsupported cache driver '$use'"),
        };
    }
}
