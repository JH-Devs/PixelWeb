<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm;

use PixelWeb\DatabaseConnection\DatabaseConnection;
use PixelWeb\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;
use PixelWeb\LiquidOrm\DataMapper\DataMapperFactory;
use PixelWeb\LiquidOrm\EntityManager\Crud;
use PixelWeb\LiquidOrm\EntityManager\EntityManagerFactory;
use PixelWeb\LiquidOrm\QueryBuilder\QueryBuilderFactory;
use PixelWeb\LiquidOrm\QueryBuilder\QueryBuilder;

class LiquidOrmManager
{
   protected string $tableSchema;
   
   protected string $tableSchemaId;

   protected DataMapperEnvironmentConfiguration $environmentConfiguration;

   protected array $options;

   /**
    * @inheritDoc
    *
    * @param string $tableSchema
    * @param string $tableSchemaId
    * @param array|null $options
    * @param DataMapperEnvironmentConfiguration $environmentConfiguration
    */
   public function __construct(string $tableSchema, string $tableSchemaId, DataMapperEnvironmentConfiguration $environmentConfiguration, ?array $options = [])
   {
    $this->tableSchema = $tableSchema;
    $this->tableSchemaId = $tableSchemaId;$this->environmentConfiguration = $environmentConfiguration;
    $this->options = $options;
    }

    /**
     * inicializační metoda, která slepí všechny komponenty dohromady a vloží do nich potřebnou závislost
    * příslušný objekt
     *
     * @return object
     */
    public function initialize() : object
    {
        $dataMapperFactory = new DataMapperFactory();
        $dataMapper = $dataMapperFactory->create(DatabaseConnection::class, DataMapperEnvironmentConfiguration::class);
        if ($dataMapper) {
            $queryBuilderFactory = new QueryBuilderFactory();
            $queryBuilder = $queryBuilderFactory->create(QueryBuilder::class);
            if ($queryBuilder) {
                $entityManagerFactory = new EntityManagerFactory($dataMapper, $queryBuilder);
                return $entityManagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchemaId, $this->options);
            }
        }
    }
	
}