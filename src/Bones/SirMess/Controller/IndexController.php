<?php


namespace Bones\SirMess\Controller;


use Silex\Application;
use Silex\ControllerProviderInterface;

class IndexController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /**
         * @var \Silex\ControllerCollection $factory
         */
        $factory = $app['controllers_factory'];

        $factory->get(
            '/',
            'Bones\SirMess\Controller\IndexController::index'
        );

        return $factory;
    }


    public function index(Application $app)
    {


    }
}
