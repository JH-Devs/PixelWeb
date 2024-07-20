<?php

declare(strict_types=1);

namespace App\Controller;

use PixelWeb\Base\BaseController;

class HomeController extends BaseController
{
    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
    }
    public function indexAction()
    {
        echo 'Domovská stránka <br/>';
    }
    protected function before()
    {
        echo 'toto je předchozí akce háčku. <br/>';
    }
    protected function after()
    {
        echo 'toto je další akce háčku. <br/>';
    }
}