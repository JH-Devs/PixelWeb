<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\EntityManager;
use PixelWeb\LiquidOrm\EntityManager\CrudInterface;

class EntityManager implements EntityManagerInterface
{
     /**
     * @var CrudInterface
     */
    protected  CrudInterface $crud;
   /**
    * Moje konstrukční třída 
    */ 
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }
     /**
     * @inheritDoc
     */
    public function getCrud() : object
    {
        return $this->crud;
    }
	
}