<?php

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use OverflowException;

class BaseOverflowException  extends OverflowException  
{ 

    public function __construct(string $message, int $code = 0, OverflowException   $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}