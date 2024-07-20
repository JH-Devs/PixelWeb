<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use LengthException;

class BaseLengthException   extends LengthException  
{ 
    public function __construct(string $message, int $code = 0, LengthException   $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}