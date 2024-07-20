<?php
declare(strict_types=1);

namespace App\Entity;
use PixelWeb\Base\BaseEntity;

class UserEntity extends BaseEntity
{
    public function __construct(array $dirtyData)
    {
        parent::__construct($dirtyData); 
    }
	
}