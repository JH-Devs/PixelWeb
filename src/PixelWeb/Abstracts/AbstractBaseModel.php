<?php

declare(strict_types=1);

namespace PixelWeb\Abstracts;
use PixelWeb\Base\BaseModel;

abstract class AbstractBaseModel extends BaseModel
{
    abstract public function guardedId() : array; 
}