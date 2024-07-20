<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use InvalidArgumentException;

class BaseInvalidArgumentException extends InvalidArgumentException
{

    public function __construct(string $message, int $code = 0, InvalidArgumentException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}