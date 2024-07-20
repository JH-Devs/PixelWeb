<?php
declare(strict_types=1);

namespace PixelWeb\Base\Exception;

use BadFunctionCallException;

class BaseBadFunctionCallException extends BadFunctionCallException
{
    public function __construct(string $message, int $code = 0, BadFunctionCallException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
	
}