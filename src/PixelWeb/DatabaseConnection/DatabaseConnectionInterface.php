<?php 

declare(strict_types=1);

namespace PixelWeb\DatabaseConnection;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * Vytvoří nové připojení k databázi
     * 
     * @return PDO
     */
    public function open() : PDO;

    /**
     * zavře datababázové spojení
     */
    public function close() : void;
}