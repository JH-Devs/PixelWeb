<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataRepository;

use PixelWeb\Base\Exception\BaseInvalidArgumentException;
use PixelWeb\LiquidOrm\EntityManager\EntityManagerInterface;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function isArray(array $conditions) : void
    {
        if (!is_array($conditions))
        throw new BaseInvalidArgumentException('Zadaný argument není pole');
    }

    private function isEmpty(int $id) : void
    {
        if (empty($id))
            throw new BaseInvalidArgumentException('Argument by neměl být prázdný');
    }

    public function find(int $id) : array
    {
        $this->isEmpty($id);
        try{
            return $this->findOneBy(['id' => $id]);
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findAll() : array
    {
        try{
            return $this->findBy();
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }


    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
    {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findOneBy(array $conditions) : array
    {
        $this->isArray($conditions);
        return $this->em->getCrud()->read([], $conditions);
        try {

        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findObjectBy(array $conditions = [], array $selectors = []): object
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->get($selectors, $conditions);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findByIdAndDelete(array $conditions) : bool
    {
        $this->isArray($conditions);
        try {
            $result = $this->findOneBy($conditions);
            if ($result !=null && count($result) > 0) {
                $delete = $this->em->getCrud()->delete($conditions);
                if ($delete) {
                    return true;
                }
            }
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findByIdUpdate(array $fields = [], int $id) : bool
    {
        $this->isArray($fields);
        try {
            $result = $this->findOneBy([$this->em->getCrud()->getSchemaId() => $id]);
            if ($result !=null && count($result) > 0) {
                $params = (!empty($fields)) ? array_merge([$this->em->getCrud()->getSchemaId() => $id], $fields) : $fields;
                $update = $this->em->getCrud()->update($params, $this->em->getCrud()->getSchemaId());
                if ($update) {
                    return true;
                }
            }
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findWithSearchAndPaging(array $args, object $request) : array
    {
       return [];
    }
    public function findAndReturn(int $id, array $selectors = []) : self
    {
        return $this;
    }
}