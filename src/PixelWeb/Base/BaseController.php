<?php

declare(strict_types=1);

namespace PixelWeb\Base;

use PixelWeb\Base\BaseView;
use PixelWeb\Base\Exception\BaseBadMethodCallException;
use PixelWeb\Base\Exception\BaseLogicException;

class BaseController
{
    protected array $routeParams;

    protected object $twig;

    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
        $this->twig = new BaseView();
    }
	public function render(string $template, array $context = [])
    {
        if ($this->twig === null) {
            throw new BaseLogicException('Nemůžete použít metodu render, pokud není dostupný balíček Twig.');
        }
        return $this->twig->twigRender($template, $context);
    }
    public function __call($name, $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new BaseBadMethodCallException('Metoda ' . $method . ' neexistuje v ' . get_class($this));
        }
    }
    protected function before()
    { }
    protected function after()
    { }
}