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

    public function __construct(string $tableSchema, string $tableSchemaId)
    {
        if (empty($tableSchema) || empty($tableSchemaId)) {
            throw new BaseInvalidArgumentException('These arguments are required.');
        }
        $factory = new DataRepositoryFactory('basicCrud', $tableSchema, $tableSchemaId);
        $this->repository = $factory->create(DataRepository::class);
    }
    public function getRepo() : DataRepository
    {
        return $this->repository;
    }


}