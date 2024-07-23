<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\EntityManager;

interface CrudInterface
{
    /**
     * Vrátí název schématu jako řetězec
     * 
     * @return string
     */
    public function getSchema() : string;

    /**
     * Vrátí primární klíč pro schéma
     * 
     * @return string
     */
    public function getSchemaId() : string;

     /**
     * Vrátí poslední vložené ID
     * 
     * @return int
     */
    public function lastId() : int;

    /**
     * Vytvoří metodu, která vloží data do tabulky
     * 
     * @param array $fields
     * @return bool
     */
    public function create(array $fields = []) : bool;

     /**
     * Vrátí pole databázových řádků na základě jednotlivých zadaných argumentů
     * 
     * @param array $selectors = []
     * @param array $conditions = []
     * @param array $parameters = []
     * @param array $optional = []
     * @return array
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array;

    /**
     * Metoda aktualizace, která aktualizuje 1 nebo více řádků dat v tabulce
     * 
     * @param array $fields
     * @param string $primaryKey
     * @return bool
     */
    public function update(array $fields = [], string $primaryKey) : bool;

     /**
     * Metoda Delete, která trvale odstraní řádek z tabulky
     * 
     * @param array $conditions
     * @return bool
     */
    public function delete(array $conditions = []) : bool;

    /**
     * Metoda vyhledávání, která vrací požadované výsledky vyhledávání
     * 
     * @param array $selectors = []
     * @param array $conditions = []
     * @return null|array
     */
    public function search(array $selectors = [], array $conditions = []) : array;

     /**
     * Vrátí vlastní řetězec dotazu. Druhý argument může přiřadit a asociativní pole
     * podmínek pro řetězec dotazu
     * 
     * @param string $rawQuery
     * @param array|null $conditions
     * @param string $resultType
     * @return mixed
     */
    public function rawQuery(string $rawQuery, array $conditions = []);

    public function get(array $selectors = [], array $conditions = []) : ?object;
   
}