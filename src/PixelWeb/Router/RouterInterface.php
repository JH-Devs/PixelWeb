<?php

declare(strict_type=1);

namespace PixelWeb\Router;

interface RouterInterface
{
    /**
     * Jednoduché přidání trasy do směrovací tabulky
     * 
     * @param string $route
     * @param array $params
     * @return void
     */

    public function add(string $route, array $params = []) : void;

    /**
     * Odešle trasu a vytvoří objekty kontroleru a spustí výchozí metodu
     * na tomto kontroleru objektu
     * 
     * @param string $url
     * @return void
     */

     public function dispatch(string $url) : void;
}