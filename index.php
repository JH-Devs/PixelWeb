<?php

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__)));

$autoload = ROOT_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
} else {
    die('Soubor automatického načítání nebyl nalezen: ' . $autoload);
}

use PixelWeb\Application\Application;
use PixelWeb\Router\RouterFactory;
use Symfony\Component\Yaml\Yaml;

/*
echo "Autoloading works!<br>"; // Přidejte tento řádek pro testování*/
/*
// Testovací výpis autoloading mapy
$classes = require ROOT_PATH . '/vendor/composer/autoload_classmap.php';
var_dump($classes); */

try {
    $app = new Application(ROOT_PATH);
    $app->run()->setSession();

    // Načtěte trasy ze souboru YAML
    $routesFile = ROOT_PATH . '/Config/routes.yaml';
    if (!file_exists($routesFile)) {
        throw new Exception('Soubor "routes.yaml" nebyl nalezen na cestě: ' . $routesFile);
    }
    $routes = Yaml::parseFile($routesFile);

    // Získání URL cesty
    $url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Vytvořte a nastavte router pomocí RouterFactory
    $routerFactory = new RouterFactory($url, $routes);
    $routerFactory->create(PixelWeb\Router\Router::class)->buildRoutes();

} catch (Throwable $e) {
    echo "Zachycená vyjímka: " . $e->getMessage() . "<br>";
    echo "V souboru: " . $e->getFile() . "<br>";
    echo "na řádku: " . $e->getLine() . "<br>";
}
