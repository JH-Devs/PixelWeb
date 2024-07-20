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
        // Převod cesty na regulární výraz: úniková lomítka
        $route = preg_replace('/\//', '\\/', $route);
         // Přidá počáteční a koncové oddělovače a příznak nerozlišující malá a velká písmena
         $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
     }
       /**
     * @inheritDoc
     */

     public function dispatch(string $url): void
     {
         if ($this->match($url)) {
             $controllerString = $this->transformUpperCamelCase($this->params['controller']) . $this->controllerSuffix;
             $controllerString = $this->getNamespace($controllerString);
     
           /*  echo "Attempting to load controller: " . $controllerString . "<br>"; */
     
             if (class_exists($controllerString)) {
             /*   echo "Controller class found: " . */$controllerString . "<br>";
                 $controllerObject = new $controllerString($this->params);
                 $action = $this->transformCamelCase($this->params['action']);
     
                 if (\is_callable([$controllerObject, $action])) {
                  /*   echo "Method found: " . $action . "<br>";*/
                     $controllerObject->$action();
                 } else {
                     throw new RouterBadMethodCallException('Method ' . $action . ' not found in controller ' . $controllerString);
                 }
             } else {
                 throw new RouterException('Controller class not found: ' . $controllerString);
             }
         } else {
             throw new RouterException('No route matched.');
         }
     }
     
     
 
     public function transformUpperCamelCase(string $string): string 
     {
         return str_replace(' ', '', ucwords(str_replace('-', ' ', strtolower($string))));
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
                $this->params = $params;

                 // Debugging output
             /*   echo "Route matched: " . $route . "<br>";
                 echo "Controller: " . $this->params['controller'] . "<br>";
                 echo "Action: " . $this->params['action'] . "<br>"; */
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
        return $namespace . $string;
    }
    
}