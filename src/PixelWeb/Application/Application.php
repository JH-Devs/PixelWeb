<?php 

declare(strict_types=1);

namespace PixelWeb\Application;

use PixelWeb\Application\Config;
use PixelWeb\Traits\SystemTrait;
use PixelWeb\Router\RouterFactory;
use PixelWeb\Yaml\YamlConfig;

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
        defined('DS') or define('DS', '/');
        defined('APP_ROOT') or define('APP_ROOT', $this->appRoot);
        defined('CONFIG_PATH') or define('CONFIG_PATH', APP_ROOT . DS . 'Config');
        defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App/');
        defined('LOG_DIR') or define('LOG_DIR', APP_ROOT . DS . 'tmp/log');
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
    public function setSession()
    {
        SystemTrait::sessionInit(true);
        return $this;
    }
    public function setRouteHandler(string $url = null, array $routes = []) : self
    {
        $url = ($url) ? $url : $_SERVER['QUERY_STRING'];
        $routes = ($routes) ? $routes : YamlConfig::file('routes');
        
        $factory = new RouterFactory($url, $routes);
        $factory->create(\PixelWeb\Router\Router::class)->buildRoutes();
        return $this;
    }
}