<?php 

declare(strict_types=1);

namespace PixelWeb\Application;

use PixelWeb\Application\Config;

class Application
{
    protected $appRoot;
    public function __construct(string $appRoot)
    {
        $this->appRoot = $appRoot;
    }

    public function run() : self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::PIXELWEB_MIN_VERSION, '<')) {
            die(sprintf('Používáte PHP %s, ale základní framework vyžaduje alespo%n pho %s', $phpVersion, $coreVersion));
        }
        $this->environment();
        $this->errorHandler();

        return $this;
    }

    private function constants() : void
    {
        define('DS', '/');
        define('APP_ROOT', $this->appRoot);
        define('CONFIG_PATH', APP_ROOT . DS . 'Config');
        define('TEMPLATE_PATH', APP_ROOT . DS . 'App/templates');
        define('LOG_DIR', APP_ROOT . DS . 'tmp/log');
    }

    private function environment()
    {
        ini_set('default_charset', 'UTF-8');
    }

    private function errorHandler() : void
    {
        error_reporting(E_ALL | E_STRICT);
        set_error_handler('PixelWeb\ErrorHandling\ErrorHandling::errorHandler');
        set_exception_handler('PixelWeb\ErrorHandling\ErrorHandling::exceptionHandler');
    }
}