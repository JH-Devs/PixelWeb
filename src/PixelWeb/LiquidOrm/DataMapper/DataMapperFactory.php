<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataMapper;

use PixelWeb\Base\Exception\BaseUnexpectedValueException;
use PixelWeb\DatabaseConnection\DatabaseConnectionInterface;
use PixelWeb\Yaml\YamlConfig;

class DataMapperFactory
{
    /**
     * moje konstrukční třída
     * 
     * @return void
     */
    public function __construct()
    {

    }
       /**
     * Vytvoří instanci DataMapper
     * 
     * @param string $databaseConnectionClass Název třídy pro připojení k databázi
     * @param string $dataMapperEnvironmentConfiguration Název třídy pro konfiguraci prostředí
     * @return DataMapperInterface
     * @throws DataMapperException
     */
  /* public function create(string $databaseConnectionString, string $dataMapperEnviromentConfiguration) : DataMapperInterface
    {
        $credentials = (new $dataMapperEnviromentConfiguration([])) -> getDatabaseCredentials('mysql');
        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException($databaseConnectionString . 'není platné rozhraní pro připojení k databázi');
        }
        return new DataMapper($databaseConnectionObject);
    } */
	 /**
     * Creates the data mapper object and inject the dependency for this object. We are also
     * creating the DatabaseConnection Object
     * $dataMapperEnvironmentConfiguration get instantiated in the DataRepositoryFactory
     *
     * @param string $databaseConnectionString
     * @param object $dataMapperEnvironmentConfiguration
     * @return DataMapperInterface
     * @throws BaseUnexpectedValueException
     */
    public function create(string $databaseConnectionString, object $dataMapperEnvironmentConfiguration) : DataMapperInterface
    {
        // Create databaseConnection Object and pass the database credentials in
        $credentials = $dataMapperEnvironmentConfiguration->getDatabaseCredentials(YamlConfig::file('app')['pdo_driver']);
        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new BaseUnexpectedValueException($databaseConnectionString . ' is not a valid database connection object');
        }
        return new DataMapper($databaseConnectionObject);
    }
}