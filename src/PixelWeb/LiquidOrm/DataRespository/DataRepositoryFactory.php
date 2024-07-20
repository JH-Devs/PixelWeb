<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataRepository;

use PixelWeb\Base\Exception\BaseUnexpectedValueException;
use PixelWeb\LiquidOrm\DataRespository\Exception\DataRepositoryException;

class DataRepositoryFactory 
{
     /** @var string */
    protected string $tableSchema;

     /** @var string */
    protected string $tableSchemaId;

    /** @var string */
    protected string $crudIdentifier;

    /**
     * Moje konstrukční třída
     *
     * @param string $tableSchema
     * @param string $tableSchemaId
     * @param string $crudIdentifier
     */
    public function __construct(string $tableSchema, string $tableSchemaId, string $crudIdentifier)
    {
        $this->tableSchema = $tableSchema;
        $this->tableSchemaId = $tableSchemaId;$this->crudIdentifier = $crudIdentifier;
    }
	
    public function create(string $dataRepositoryString): DataRepositoryInterface
    {
        $dataRepositoryObject = new $dataRepositoryString();
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new BaseUnexpectedValueException($dataRepositoryString . ' není platný objekt úložiště.');
        }
        return $dataRepositoryObject;
    }
}