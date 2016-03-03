<?php


namespace Bones\SirMess\Controller;


use Bones\SirMess\Model\User;
use Doctrine\ORM\EntityManager;
use FOS\Message\Repository as ConversationRepository;
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
        /** @var EntityManager $em */
        $em = $app['orm.em'];
        var_dump($em->getRepository('FOS\Message\Driver\Doctrine\ORM\Entity\ConversationPerson'));
        return new JsonResponse(
            1
        );
    }


}
