<?php
declare(strict_types=1);

namespace PixelWeb\GlobalManager;

use PixelWeb\GlobalManager\Exception\GlobalManagerException;
use PixelWeb\GlobalManager\Exception\GlobalManagerInvalidArgumentException;
use PixelWeb\GlobalManager\GlobalManagerInterface;
use Throwable;

class GlobalManager implements GlobalManagerInterface
{
    /**
     * @inheritDoc
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value) : void
    {
        $GLOBALS[$key] = $value;
    }
    /**
     * @inheritDoc
     *
     * @param string $key
     * @return mixed
     * @throws GlobalManagerException
     */
    public static function get(string $key)
    {
        self::isGlobalValid($key);
        try {
            return $GLOBALS[$key];
        } catch(Throwable $throwable) {
            throw new GlobalManagerException('Při pokusu o načtení dat byla vyvolána výjimka.');
        }
    }
    /**
     * Zkontroluje, zda máme platný klíč a není prázdný, jinak vyvolá výjimku
     *
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidArgumentException
     */
    private static function isGlobalValid(string $key) : void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Neplatný globální klíč. Ujistěte se, že jste nastavili globální stav pro' . $key);
        }
        if (empty($key)) {
            throw new GlobalManagerInvalidArgumentException('Argument nemůže být prázdný.');
        }
    }
}