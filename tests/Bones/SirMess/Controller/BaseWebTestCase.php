<?php


namespace tests\Bones\SirMess\Controller;


use Silex\WebTestCase;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class BaseWebTestCase extends WebTestCase
{

    /**
     * Creates the application.
     *
     * @return HttpKernelInterface
     */
    public function createApplication()
    {
        // app.php must return an Application instance
        $app = require __DIR__ . '/../../../../app/bootstrap.php';

        $app['debug'] = true;
        unset($app['exception_handler']);

        return $app;
    }
}
