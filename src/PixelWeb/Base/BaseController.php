<?php

declare(strict_types=1);

namespace PixelWeb\Base;

use PixelWeb\Base\BaseView;
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
}