<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataMapper;

interface DataMapperInterface
{
     /**
     * Připraví řetězec dotazu
     * 
     * @param string $sqlQuery
     * @return self
     */
    public function prepare(string $sqlQuery) : self;

    /**
     * Explicitní datový typ pro parametr pomocí konstant PDO::PARAM_*.
     * 
     * @param mixed $value
     * @return mixed
     */
    public function bind($value);

     /**
     * Kombinační metoda, která kombinuje obě výše uvedené metody. Jedním z nich je
     * optimalizovaní pro vazebné vyhledávací dotazy. První a druhý argument $type
     * je nastaven na vyhledávání
     * 
     * @param array $fields
     * @param bool $isSearch
     * @return mixed
     */
    public function bindParameters(array $fields, bool $isSearch = false) : self;
     /**
     * Vrátí počet řádků ovlivněných příkazem DELETE, INSERT nebo UPDATE.
     * 
     * @return int|null
     */
    public function numRows() : int;

     /**
     * Proveďte funkci, která provede připravený příkaz
     * 
     * @return void
     */
    public function execute();

     /**
     * Vrátí jeden řádek databáze jako objekt
     * 
     * @return object
     */
    public function result() : object;

      /**
     * Vrátí všechny řádky v databázi jako pole
     * 
     * @return array
     */
    public function results() : array;

    /**
     * Vrátí sloupec databáze
     *
     * @return mixed
     */
    public function column();

     /**
     * Vrátí poslední vložené ID řádku z databázové tabulky
     * 
     * @return int
     * @throws Throwable
     */
    public function getLastId() : int;

}