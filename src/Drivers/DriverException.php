<?php

declare(strict_types=1);

namespace Phico\Cache\Drivers;

class DriverException extends \Exception
{
    public function __construct(string $message = "", \Throwable $previous = null)
    {
        $this->message = $message;
        $this->previous = $previous;
    }
}
