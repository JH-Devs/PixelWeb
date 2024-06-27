<?php

declare(strict_types=1);

namespace PixelWeb\LiquidOrm\DataRepository;

use PixelWeb\LiquidOrm\DataRespository\Exception\DataRepositoryInvalidArgumentException;
use PixelWeb\LiquidOrm\EntityManager\EntityManagerInterface;
use Throwable;

class DataRepository implements DataRepositoryInterface
{
    protected EntityManagerInterface $em;

    /**
     * @inheritdoc
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
	
    /**
     * @inheritdoc
     *
     * @param array $conditions
     * @return void
     */
    private function isArray(array $conditions) : void
    {
        if (!is_array($conditions))
        throw new DataRepositoryInvalidArgumentException('Zadaný argument není pole');
    }
    /**
     * @inheritdoc
     *
     * @param integer $id
     * @return void
     */
    private function isEmpty(int $id) : void
    {
        if (empty($id))
            throw new DataRepositoryInvalidArgumentException('Argument by neměl být prázdný');
    }
    /**
     * @inheritdoc
     *
     * @param integer $id
     * @return array
     */
    public function find(int $id) : array
    {
        $this->isEmpty($id);
        try{
            return $this->findOneBy(['id' => $id]);
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    /**
     * @inheritdoc
     *
     * @return array
     */
    public function findAll() : array
    {
        try{
            return $this->em->getCrud()->read();
        }catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $optional
     * @return array
     */
    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []) : array
    {
        try {
            return $this->em->getCrud()->read($selectors, $conditions, $parameters, $optional);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * @inheritdoc
     *
     * @param array $conditions
     * @return array
     */
    public function findOneBy(array $conditions) : array
    {
        $this->isArray($conditions);
        return $this->em->getCrud()->read([], $conditions);
        try {

        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    /**
     * @inheritdoc
     *
     * @param array $conditions
     * @param array $selectors
     * @return object
     */
    public function findObjectBy(array $conditions = [], array $selectors = []): object
    {
        $this->isArray($conditions);
        try {
            return $this->em->getCrud()->get($selectors, $conditions);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    /**
     * @inheritdoc
     *
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $optional
     * @return array
     */
    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $optional) : array
    {
        try {
            return $this->em->getCrud()->search($selectors, $conditions, $parameters, $optional);
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
    /**
     * @inheritdoc
     *
     * @param array $conditions
     * @return boolean
     */
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
    /**
     * @inheritdoc
     *
     * @param array $fields
     * @param integer $id
     * @return boolean
     */
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