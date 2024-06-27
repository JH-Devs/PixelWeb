<?php

declare(strict_types=1);

namespace PixelWeb\Router;

use PixelWeb\Router\Exception\RouterBadMethodCallException;
use PixelWeb\Router\Exception\RouterException;
use PixelWeb\Router\RouterInterface;

class Router implements RouterInterface
{
     /**
     * vrátí pole cesty z naší směrovací tabulky
     * @var array
     */
    protected array $routes = [];

     /**
     * vrátí pole parametrů cesty
     * @var array
     */
    protected array $params = [];

    /**
     * Přidá příponu k názvu kontroleru
     * @var string
     */
    protected string $controllerSuffix = 'controller';

      /**
     * @inheritDoc
     */

     public function add(string $route, array $params = []) :void
     {
        $this->routes[$route] = $params;
     }
       /**
     * @inheritDoc
     */

     public function dispatch(string $url) : void
     {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params['action'];
                $action = $this->transformUpperCamelCase($action);

                if (\is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new RouterBadMethodCallException();
                }
            } else {
                throw new RouterException();
            }
        } else {
            throw new RouterException();
        }
     }
     public function transformUpperCamelCase(string $string) : string 
     {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
     }
     public function transformCamelCase(string $string) : string
     {
        return \lcfirst($this->transformUpperCamelCase($string));
     }

      /**
     * Přiřaďí cestu k trasám ve směrovací tabulce nastavením vlastnosti $this->params
     * pokud je nalezena cesta
     * 
     * @param string $url
     * @return bool
     */

    private function match(string $url) : bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params ;
                return true;
            }
        }
        return false;
    }
        /**
     * Získá jmenný prostor pro třídu kontroleru, jmenný prostor definovaný v parametrech cesty
     * pouze pokud byl přidán.
     * 
     * @param string $string
     * @return string
     */
    public function getNamespace(string $string) : string
    {
        $namespace = 'App\Controller\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .=$this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}