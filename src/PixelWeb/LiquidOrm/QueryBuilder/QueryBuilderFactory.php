<?php 
declare(strict_types=1);

namespace PixelWeb\LiquidOrm\QueryBuilder;

use PixelWeb\LiquidOrm\QueryBuilder\Exception\QueryBuilderException;
use PixelWeb\LiquidOrm\QueryBuilder\QueryBuilderInterface;

class QueryBuilderFactory
{
    /**
     * Moje konstrukční třída
     * 
     * @return void
     */
    public function __construct()
    {

    }
    public function create(string $queryBuilderString) : QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if (!$queryBuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderException($queryBuilderString . ' není platný tvůrce dotazů.');
        }
        return $queryBuilderObject;
    }
}