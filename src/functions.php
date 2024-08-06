<?php

if (!function_exists('cache')) {
    function cache(null|string $use = null): \Phico\Cache\Cache
    {
        $config = config()->get("cache.servers.$use");
        if (is_null($config)) {
            throw new InvalidArgumentException("Cannot create Cache driver with unknown server config '$use'");
        }

        return new \Phico\Cache\Cache($config);
    }
}
