<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataMapper;

use PDO;
use PDOStatement;
use PixelWeb\DatabaseConnection\DatabaseConnectionInterface;
use PixelWeb\DataMapper\Exception\DataMapperException;
use Throwable;

class DataMapper implements DataMapperInterface
{
    /** @var DatabaseConnectionInterface */
    private DatabaseConnectionInterface $dbh;

    /** @var PDOStatement */
    private PDOStatement $stmt;
    
    /**
     * Moje konstrukční třída
     * 
     * @param DatabaseConnectionInterface
     * @return void
     */
    public function __construct(DatabaseConnectionInterface $dbh){
        $this->dbh = $dbh;
    }
	/**
     * Zkontrolujte, zda příchozí $value není prázdný, jinak vyvoláte výjimku
     * 
     * @param mixed $value
     * @param string | null $errorMessage
     * @return void
     * @throws DataMapperException
     */
    private function isEmpty($value, string $errorMessage = null) :void
    {
        if (empty($value)) {
            throw new DataMapperException($errorMessage);
        }
    }
    /**
     * Zkontrolujte příchozí argument $hodnota je pole, jinak vyvolá výjimku
     * 
     * @param array $value
     * @return void
     * @throws 
     */
    private function isArray(array $value) :void
    {
        if (is_array($value)) {
            throw new DataMapperException('Váš argument musí být pole');
        }
    }
      /**
     * @inheritDoc
     */
    public function prepare(string $sqlQuery) :self
    {
        $this->isEmpty($sqlQuery);
        $this->stmt = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }
        /**
     * @inheritDoc
     *
     * @param [type] $value
     * @return void
     */
    public function bind($value)
    {
        try {
            switch($value) {
                case is_bool($value) :
                case intval($value) :
                    $dataType = PDO::PARAM_INT;
                    break;
                    case is_null($value) :
                        $dataType = PDO::PARAM_NULL;
                        break;
                        default :
                        $dataType = PDO::PARAM_STR;
                        break;
            }
            return $dataType;
        } catch (DataMapperException $exception) {
            throw $exception;
        }
    }
       /**
     * @inheritDoc
     *
     * @param array $fields
     * @param boolean $isSearch
     * @return self
     */
    public function bindParameters(array $fields, bool $isSearch = false) : self
    {
        if (is_array($fields)) {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type) {
                return $this;
            }
        }
        return false; 
    }
        /**
     * Sváže hodnotu s odpovídajícím názvem nebo zástupným symbolem otazníku v SQL
     * výpis, který byl použit k přípravě výpisu
     * 
     * @param array $fields
     * @return PDOStatement
     * @throws 
     */
    protected function bindValues(array $fields)
    {
        $this->isArray($fields); 
        foreach ($fields as $key =>$value) {
            $this->stmt->bindValue(':' . $key, $value, $this->bind($value));
        }
        return $this->stmt; 
    }
        /**
     * Sváže hodnotu s odpovídajícím názvem nebo zástupným symbolem otazníku
     * v příkazu SQL, který byl použit k přípravě příkazu. Podobný
     * výše, ale optimalizované pro vyhledávací dotazy
     * 
     * @param array $fields
     * @return mixed
     */
    protected function bindSearchValues(array $fields) : PDOStatement
    {
        $this->isArray($fields); 
        foreach ($fields as $key =>$value) {
            $this->stmt->bindValue(':' . $key, '%' . $value . '%', $this->bind($value));
        }
        return $this->stmt; 
    }
     /**
     * @inheritDoc
     * 
     * @return integer
     */
    public function numRows() : int
    {
        if ($this->stmt) 
        return $this->stmt->rowCount();
    }

    /**
     * @inheritDoc
     * 
     * @return void
     */
    public function execute()
    {
        if ($this->stmt)
        $this->stmt->execute();
    }   

    /**
     * @inheritDoc
     * 
     * @return object
     */
    public function result(): object
    {
        if ($this->stmt) 
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @inheritDoc
     * 
     * @return array
     */
    public function results(): array
    {
        if ($this->stmt) 
        return $this->stmt->fetchAll();
    }

    /**
     * @inheritDoc
     */
    public function column()
    {
        if ($this->stmt) 
        return $this->stmt->fetchColumn();
    }

    /**
     * @inheritDoc
     * 
     * @return integer
     */
    public function getLastId(): int
    {
        try {
            if ($this->dbh->open()) {
                $lastId = $this->dbh->open()->lastInsertId();
                if (!empty($lastId)) {
                    return intval($lastId);
                }
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }
}