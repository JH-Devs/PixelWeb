<?php

declare(strict_types=1);

namespace App\Controller;

use PixelWeb\Base\BaseController;
use App\Model\UserModel;
use PixelWeb\LiquidOrm\EntityManager\Crud;
use PixelWeb\LiquidOrm\EntityManager\EntityManager;

class HomeController extends BaseController
{
    public function __construct($routeParams)
    {
        parent::__construct($routeParams);
    }
    public function indexAction()
    {
        /*
        $user = new UserModel();
        $data = $user->getRepo()->findAll();
        var_dump($data);
       */

      /*  $user = new UserModel();
        $data = $user->getRepo()->findAll();

        print_r($data);*/
    }
    protected function before()
    { }
    protected function after()
    { }
}