<?php

declare(strict_types=1);

namespace PixelWeb\Session;

use PixelWeb\Session\SessionFactory;

class SessionManager
{
    /**
     * Vytvoří instanci naší továrny na session (relace) a předá do ní výchozí úložiště session. Název session a pole možností získá z hlavních YAML konfiguračních souborů.
     *
     * @return void
     */
    public static function initialize() : Object
    {
        $factory = new SessionFactory();
        return $factory->create('', \PixelWeb\Session\Storage\NativeSessionStorage::class, array());
    }

}