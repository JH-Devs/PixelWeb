<?php

declare(strict_types=1);

namespace PixelWeb\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    public function __constructor($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
	
}