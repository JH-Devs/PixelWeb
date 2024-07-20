<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use OutOfBoundsException;

class BaseOutOfRangeException extends OutOfBoundsException
{ 
    public function __construct(string $message, int $code = 0, OutOfBoundsException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}