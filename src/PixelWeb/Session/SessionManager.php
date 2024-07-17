<?php

declare(strict_types=1);

namespace PixelWeb\Session;

use PixelWeb\Session\SessionFactory;
use PixelWeb\Yaml\YamlConfig;

class SessionManager
{
    /**
     * Vytvoří instanci naší továrny na session (relace) a předá do ní výchozí úložiště session. Název session a pole možností získá z hlavních YAML konfiguračních souborů.
     *
     * @return SessionInterface
     */
    public static function initialize() : SessionInterface
    {
        $config = YamlConfig::file('session');
        $sessionName = $config['session_name'];
        $options = $config;

        $factory = new SessionFactory();
        return $factory->create($sessionName, \PixelWeb\Session\Storage\NativeSessionStorage::class, $options);
    }
}
