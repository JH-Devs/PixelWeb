<?php

declare(strict_types=1);

namespace PixelWeb\Base;

use PixelWeb\Twig\TwigExtension;
use PixelWeb\Yaml\YamlConfig;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class BaseView
{
    public function getTemplate(string $template, array $context = []) 
    {
        static $twig;
        if ($twig === null) {
            $loader = new FilesystemLoader('templates', TEMPLATE_PATH);
            $twig = new Environment($loader, YamlConfig::file('twig'));
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TwigExtension());
        }
        return $twig->render($template, $context);
    }
    public function twigRender(string $template, array $context = [])
    {
        echo $this->getTemplate($template, $context);
    }
}
