<?php

declare(strict_types=1);

namespace PixelWeb\Session\Storage;

interface SessionStorageInterface
{
    /**
     * Obal pro session_name s explicitním argumentem pro nastavení session_name
     *
     * @param string $sessionName
     * @return void
     */
    public function setSessionName(string $sessionName) : void;
    /**
     * Obal pro session_name vrací název relace
     *
     * @return string
     */
    public function getSessionName() : string;
    /**
     * Obal pro session_id s explicitním argumentem pro nastavení session_id
     *
     * @param [type] $sessionId
     * @return void
     */
    public function setSessionId(string $sessionId) : void;
    /**
     * Obal pro session_id, který vrací aktuální session_id
     *
     * @return string
     */
    public function getSessionId();
    /**
     * Nastavuje konkrétní hodnotu konkrétnímu klíči relace
     *
     * @param string $key Klíč položky k uložení
     * @param mixed  $value Hodnota položky k uložení. Musí být serializovatelná
     * @return void
     */
    public function setSession(string $key, $value) : void;
    /**
     * Nastaví konkrétní hodnotu na konkrétní klíč pole relace
     *
     * @param string $key Klíč položky k uložení
     * @param mixed  $value Hodnota položky k uložení. Musí být serializovatelná
     * @return void
     */
    public function setArraySession(string $key, $value) : void;
    /**
     * získá/vrátí hodnotu konkrétního klíče relace
     *
     * @param string $key Klíč položky k uložení
     * @param mixed $default Výchozí hodnota, která se vrátí, pokud hodnotu požadavku nelze nalézt
     * @return mixed
     */
    public function getSession(string $key, $default = null);
    /**
     * Odebere hodnotu pro zadaný klíč z relace
     *
     * @param string $key Klíč položky, která bude deaktivována
     * @return void
     */
    public function deleteSession(string $key) : void;
    /**
     * Zničí relaci. Spolu se soubory cookie relace
     *
     * @return void
     */
    public function invalidate() : void;
    /**
     * Vrátí požadovanou hodnotu a odstraní ji z relace
     *
     * @param string $key Klíč pro načtení a odstranění hodnoty
     * @param mixed $default Výchozí hodnota, která se vrátí, pokud požadovanou hodnotu nelze nalézt
     * @return mixed
     */
    public function flush(string $key, $default = null);
    /**
     * Určuje, zda je položka přítomna v relaci
     *
     * @param string $key Klíč položky relace
     * @return boolean
     */
    public function hasSession(string $key) : bool;

}