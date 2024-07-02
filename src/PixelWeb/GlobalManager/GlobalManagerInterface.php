<?php

declare(strict_types=1);

namespace PixelWeb\GlobalManager;

interface GlobalManagerInterface
{
    /**
     * Nastaví globální proměnou
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value) : void;

    /**
     * Získá hodnotu nastavené globální proměnné
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);
}