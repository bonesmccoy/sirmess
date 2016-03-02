<?php


namespace Bones\SirMess\Controller;


use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


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

        return new JsonResponse(
            array(
                'message' => 'Welcome To SirMess',
                'version' => '0.1'
            )
        );
    }
}
