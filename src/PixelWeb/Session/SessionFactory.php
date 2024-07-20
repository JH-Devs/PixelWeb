<?php

declare(strict_types=1);

namespace PixelWeb\Session;

use PixelWeb\Session\Storage\SessionStorageInterface;
use PixelWeb\Session\SessionInterface;
use PixelWeb\Session\Exception\SessionStorageInvalidArgumentException;

class SessionFactory
{
    public function __construct()
    {

    }

    public function create(string $sessionName, string $storageString, array $options = []) : SessionInterface
    {
        $storageObject = new $storageString($options);
        if (!$storageObject instanceof SessionStorageInterface) {
            throw new SessionStorageInvalidArgumentException($storageString . ' není platný objekt úložiště relace.');
        }
        // Debugovací výpis
       /* echo 'Typ objektu úložiště: ' . get_class($storageObject) . '<br>';*/

        return new Session($storageObject, $sessionName); // Změněné pořadí parametrů
    }
}
