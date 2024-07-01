<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\EntityManager;

use PixelWeb\LiquidOrm\DataMapper\DataMapperInterface;
use PixelWeb\LiquidOrm\EntityManager\Exception\CrudException;
use PixelWeb\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use PixelWeb\LiquidOrm\EntityManager\EntityManagerInterface;

class EntityManagerFactory
{
    /** @var DataMapperInterface */
    protected DataMapperInterface $dataMapper;

    /** @var QueryBuilderInterface */
    protected QueryBuilderInterface $queryBuilder;

    /**
     * Moje konstrukční třída
     *
     * @param DataMapperInterface $dataMapper
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(DataMapperInterface $dataMapper, QueryBuilderInterface $queryBuilder)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
    }
    /**
     *  @inheritdoc
     *
     * @param string $crudString
     * @param string $tableSchema
     * @param string $tableSchemaId
     * @param array $options
     * @return EntityManagerInterface
     */
    public function create(string $crudString, string $tableSchema, string $tableSchemaId, array $options = []) : EntityManagerInterface
    {
        $crudObject = new $crudString($this->dataMapper, $this->queryBuilder, $tableSchema, $tableSchemaId, $options);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudException($crudString . ' není platný CRUD objekt.');
        }
        return new EntityManager($crudObject);
    }
	
}