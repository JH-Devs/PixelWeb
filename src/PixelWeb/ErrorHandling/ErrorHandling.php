<?php

declare(strict_types=1);

namespace PixelWeb\ErrorHandling;

use ErrorException;
use PixelWeb\Base\BaseView;

class ErrorHandling
{
    /**
     * Obsluha chyb. Převede všechny chyby na výjimku vyvoláním
     * ErrorException
     *
     * @param [type] $severity
     * @param [type] $message
     * @param [type] $file
     * @param [type] $line
     * @return void
     */
    public static function errorHandler($severity, $message, $file, $line)
    {
        if (!(error_reporting() && $severity)) {
            return;
        }
        throw new ErrorException($message, 0, $file, $line);
    }
      /**
     * Exception handler
     *
     * @param Exception $exception The exception
     * @return void
     * @throws Exception
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();
        if ($code !==404) {
            $code = 500;
        }
        http_response_code($code);

        $error = true;
        if ($error) {
             echo "<h1>Kritické selhání</h1>";
             echo "<p>Nezachycená výjimka: " . get_class($exception) ."</p>";
             echo "<p>Zpráva:" . $exception->getMessage() . "</p>";
             echo "<p>Zásobník volání: " . $exception->getTraceAsString() . "</p>";
             echo "<p>Vyvoláno v  " . $exception->getFile() . " na řádku " . $exception->getLine() . "</p>";
        } else {
            $errorLog = LOG_DIR . "/" . date("d-m-Y H:i:s") . ".txt";
            ini_set('error_log', $errorLog);
            $message = "Nezachycená výjimka: " . get_class($exception); 
            $message .= " se zprávou " . $exception->getMessage(); 
            $message .= "\nZásobník volání: " . $exception->getTraceAsString(); 
            $message .= "\nVyvoláno v " . $exception->getFile() . " na řádku " . $exception->getLine(); 

            error_log($message);

            echo (new BaseView)->getTemplate("error/{$code}.html.twig", ["error_message" => $message]); 
        }
    }
}