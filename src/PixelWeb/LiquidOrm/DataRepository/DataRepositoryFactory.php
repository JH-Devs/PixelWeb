<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataRepository;

use PixelWeb\Base\Exception\BaseUnexpectedValueException;
use PixelWeb\LiquidOrm\DataMapper\DataMapperEnvironmentConfiguration;
use PixelWeb\LiquidOrm\LiquidOrmManager;
use PixelWeb\Yaml\YamlConfig;

class DataRepositoryFactory 
{
    protected string $tableSchema;

    protected string $tableSchemaId;

    protected string $crudIdentifier;

    public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaId)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaId = $tableSchemaId;
    }
	
    public function create(string $dataRepositoryString) : DataRepositoryInterface
    {
        $entityManager = []/*$this->initializeLiquidOrmManager()*/;
        $dataRepositoryObject = new $dataRepositoryString($entityManager);
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new BaseUnexpectedValueException($dataRepositoryString . ' není platný objekt úložiště.');
        }
        return $dataRepositoryObject;
    }
    /*
    public function initializeLiquidOrmManager()
    {
        $environmentConfiguration = new DataMapperEnvironmentConfiguration(YamlConfig::file('database'));
        $ormManager = new LiquidOrmManager($environmentConfiguration, $this->tableSchema, $this->tableSchemaId);
        return $ormManager->initialize();
    }*/
}