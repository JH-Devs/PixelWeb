<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataMapper;
use PixelWeb\DatabaseConnection\DatabaseConnectionInterface;
use PixelWeb\DataMapper\Exception\DataMapperException;

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
    public function create(string $databaseConnectionString, string $dataMapperEnviromentConfiguration) : DataMapperInterface
    {
        $credentials = (new $dataMapperEnviromentConfiguration([])) -> getDatabaseCredentials('mysql');
        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface) {
            throw new DataMapperException($databaseConnectionString . 'není platné rozhraní pro připojení k databázi');
        }
        return new DataMapper($databaseConnectionObject);
    }
	
}