<?php

namespace Bones\SirMess\Controller;

use Bones\Message\Model\Person;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MailboxControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {

        /**
         * @var ControllerCollection
         */
        $factory = $app['controllers_factory'];

        $factory->get(
            '/',
            __CLASS__.'::index'
        );

        $factory->get('/inbox/{personId}',
            __CLASS__.'::getInbox'
        );

        $factory->get('/outbox/{personId}',
            __CLASS__.'::getOutbox'
        );

        return $factory;
    }

    public function index(Application $app)
    {
        return new JsonResponse(
            array(
                'message' => 'Welcome To SirMess',
                'version' => '0.1',
            )
        );
    }

    public function getInbox(Application $app, $personId)
    {

        /** @var Request $request */
        $request = $app['request'];
        $offset = $request->query->get('offset', null);
        $limit = $request->query->get('limit', null);

        $person = new Person($personId);

        $inbox = $app['bones.message.mailbox']->getInbox($person, $offset, $limit);

        return $this->returnJsonResponse($app, $inbox);
    }

    public function getOutbox(Application $app, $personId)
    {
        /** @var Request $request */
        $request = $app['request'];
        $offset = $request->query->get('offset', null);
        $limit = $request->query->get('limit', null);

        $person = new Person($personId);

        $outbox = $app['bones.message.mailbox']->getOutbox($person, $offset, $limit);

        return $this->returnJsonResponse($app, $outbox);
    }

    /**
     * @param Application $app
     * @param $data
     *
     * @return Response
     */
    private function returnJsonResponse(Application $app, $data)
    {
        $response = $app['serializer']->serialize($data, 'json');

        return new Response($response, 200, array('Content-Type' => 'application/json'));
    }
}
