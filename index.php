<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__)));

$autoload = ROOT_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
} else {
    die('Autoload file not found: ' . $autoload);
}

use PixelWeb\Application\Application;

echo "Autoloading works!<br>"; // Přidejte tento řádek pro testování

// Testovací výpis autoloading mapy
$classes = require ROOT_PATH . '/vendor/composer/autoload_classmap.php';
var_dump($classes);

try {
    $app = new Application(ROOT_PATH);
    $app->run()->setSession();

} catch (Throwable $e) {
    echo "Caught exception: " . $e->getMessage() . "<br>";
    echo "In file: " . $e->getFile() . "<br>";
    echo "On line: " . $e->getLine() . "<br>";
}
