<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataMapper;

use PixelWeb\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
    /**
     * @var array
     */
    private array $credentials = [];

    /**
     * Moje konstrukční třída
     * 
     * @param array $credentials
     * @return void
     */

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }
        /**
     * Získání pole připojení k databázi definované uživatelem
     * 
     * @param string $driver
     * @return array
     */
	public function getDatabaseCredentials(string $driver) : array
    {
        $connectionArray = [];
        $this->isCredentialsValid($driver);
        foreach ($this->credentials as $credential) {
            if (array_key_exists($driver, $credential)) {
                $connectionArray = $credential($driver);
            }
        }
        return $connectionArray;
    }
       /**
     * Kontroluje platnost přihlašovacích údajů
     * 
     * @param string $driver
     * @return void
     */
    private function isCredentialsValid(string $driver) : void
    {
        if (empty($driver) && !is_string($driver)) {
            throw new DataMapperInvalidArgumentException('Neplatný argument. Buď chybí nebo je neplatný datový typ');
        }
        if (!is_array($this->credentials)) {
            throw new DataMapperInvalidArgumentException('Neplatné prověření.');
        }
        if (!in_array($driver, array_keys($this->credentials[$driver]))) {
            throw new DataMapperInvalidArgumentException('Neplatné nebo nepodporovatelný databázový ovladač.');
        }
    }
}