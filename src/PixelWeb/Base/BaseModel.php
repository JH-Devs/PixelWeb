<?php

declare(strict_types=1);

namespace PixelWeb\Base;

use PixelWeb\Base\Exception\BaseInvalidArgumentException;
use PixelWeb\LiquidOrm\DataRepository\DataRepository;
use PixelWeb\LiquidOrm\DataRepository\DataRepositoryFactory;

class BaseModel
{
    private string $tableSchema;

    private string $tableSchemaId;

    private DataRepository $repository;

    /**
     * Moje konstrukční třída
     *
     * @param string $tableSchema
     * @param string $tableSchemaId
     * @return void
     * @throws BaseInvalidArgumentException
     */
    public function __construct(string $tableSchema, string $tableSchemaId)
    {
        if (empty($tableSchema) || empty($tableSchemaId)) {
            throw new BaseInvalidArgumentException('Tyto argumenty jsou povinné.');
        }
        $factory = new DataRepositoryFactory('', $tableSchema, $tableSchemaId);
        $this->repository = $factory->create(DataRepository::class);
    }
    /**
     * Získá objekt úložiště dat na základě modelu kontextu, ze kterého se úložiště spouští.
     *
     * @return DataRepository
     */
	public function getRepo() : DataRepository
    {
        return $this->repository;
    }
}