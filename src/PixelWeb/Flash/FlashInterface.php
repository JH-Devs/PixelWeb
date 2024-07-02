<?php

declare(strict_types=1);

namespace PixelWeb\Flash;

interface FlashInterface
{
    /**
     * Přidá flash zprávu uloženou v relaci
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    public static function add(string $message, string $type = FlashTypes::SUCCESS) : void;

    /**
     * Získá všechny zprávy v rámci relace
     *
     * @return void
     */
    public static function get();
}