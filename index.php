<?php

define('ROOT_DIR', realpath(dirname(__FILE__)));

$autoload = ROOT_DIR . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
}

use PixelWeb\Application\Application;

(new Application(ROOT_DIR))->run();