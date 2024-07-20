<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use RuntimeException;

class BaseRuntimeException  extends RuntimeException  
{ 
    public function __construct(string $message, int $code = 0, RuntimeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}