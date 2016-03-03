<?php


namespace Bones\SirMess\Controller;


use Bones\SirMess\Model\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


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

        $factory->get('/inbox/{userId}',
            'Bones\SirMess\Controller\IndexController::getInbox'
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

    public function getInbox(Application $app, $userId)
    {

        $user = new User($userId);

        $jsonResponse = $app['serializer']->serialize($user, 'json');

        return new Response($jsonResponse, 200, array('Content-Type' => 'application/json'));
    }


}
