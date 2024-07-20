<?php

declare(strict_types=1);

namespace App\Controller;

use PixelWeb\Base\BaseController;

class SecurityController extends BaseController
{
    public function __construct(array $routeParams)
    {
        parent::__construct($routeParams);
    }
    public function login()
    {
        echo 'Přihlašovací stránka';
    }
}