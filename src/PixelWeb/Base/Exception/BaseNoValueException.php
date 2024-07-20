<?php 

declare(strict_types=1);

namespace PixelWeb\Base\Exception;

class BaseNoValueException extends BaseLogicException
{
    public function __construct(string $message, int $code = 0, BaseLogicException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}