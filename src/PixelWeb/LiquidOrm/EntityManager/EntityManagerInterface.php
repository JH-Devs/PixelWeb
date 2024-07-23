<?php
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\EntityManager;

interface EntityManagerInterface
{
    public function getCrud() : object;
    
}