<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use OutOfRangeException;

class BaseOutOfRangeException   extends OutOfRangeException  
{ 
    public function __construct(string $message, int $code = 0, OutOfRangeException   $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}