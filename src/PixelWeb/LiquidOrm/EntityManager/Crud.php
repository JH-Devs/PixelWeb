<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\EntityManager;

use PixelWeb\LiquidOrm\DataMapper\DataMapper;
use PixelWeb\LiquidOrm\QueryBuilder\QueryBuilder;
use PixelWeb\LiquidOrm\EntityManager\CrudInterface;

use Throwable;

class Crud implements CrudInterface
{
    protected DataMapper $dataMapper;
    protected QueryBuilder $queryBuilder;
    protected string $tableSchema;
    protected string $tableSchemaId;
    protected array $options;

  /**
   * Moje konstrukční třída
   *
   * @param DataMapper $dataMapper
   * @param QueryBuilder $queryBuilder
   * @param string $tableSchema
   * @param string $tableSchemaId
   */
    public function __construct(DataMapper $dataMapper, QueryBuilder $queryBuilder, string $tableSchema, string $tableSchemaId, ?array $options = [])
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaId = $tableSchemaId;
        $this->options = $options;
    }
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSchema() : string
    {
        return (string)$this->tableSchema;
    }
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getSchemaId() : string
    {
        return (string)$this->tableSchemaId;
    }
    /**
     * @inheritdoc
     *
     * @return integer
     */
    public function lastId() : int
    {
        return $this->dataMapper->getLastId();
    }
   /**
    * @inheritDoc
    *
    * @param array $fields
    * @return boolean
    */
    public function create(array $fields = []) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() ==1) {
                return true;
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }
  /**
   * @inheritDoc
   *
   * @param array $selectors
   * @param array $conditions
   * @param array $parameters
   * @param array $optional
   * @return array
   */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'select', 'selectors' => $selectors, 'conditions' => $conditions, 'params' => $parameters, 'extras' => $optional];
            $query = $this->queryBuilder->buildQuery($args)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters)); 
            if ($this->dataMapper->numRows() >= 0) {
                return $this->dataMapper->results();
            }
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    /**
     * @inheritDoc
     *
     * @param array $fields
     * @param string $primaryKey
     * @return boolean
     */
    public function update(array $fields = [], string $primaryKey) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'update', 'fields' => $fields, 'primary_key' => $primaryKey];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }
   /**
    * @inheritDoc
    *
    * @param array $conditions
    * @return boolean
    */
    public function delete(array $conditions = []) : bool
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'delete', 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() == 1) {
                return true;
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }
   /**
    * @inheritDoc
    *
    * @param array $selectors
    * @param array $conditions
    * @return array
    */
    public function search(array $selectors = [], array $conditions = []) : array
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'search', 'selectors' => $selectors, 'conditions' => $conditions];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows() >= 0) {
                return $this->dataMapper->results();
            }
        }catch(Throwable $throwable) {
            throw $throwable;
        } 
    }
    /**
     * @inheritDoc
     *
     * @param string $rawQuery
     * @param array|null $conditions
     * @return void
     */
    public function rawQuery(string $rawQuery, ?array $conditions = [])
    {
        try {
            $args = ['table' => $this->getSchema(), 'type' => 'raw', 'raw' => $rawQuery, 'conditions => $conditions' ];
            $query = $this->queryBuilder->buildQuery($args)->rawQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if ($this->dataMapper->numRows()) {

            }
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    public function get(array $selectors = [], array $conditions = []) : ?Object
    {
        $args = ['table' => $this->getSchema(), 'type' => 'select', 'selectors' => $selectors, 'conditions' => $conditions];
        $query = $this->queryBuilder->buildQuery($args)->selectQuery();
        $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
        if ($this->dataMapper->numRows() >= 0) {
            return $this->dataMapper->result();
        }
    }
}