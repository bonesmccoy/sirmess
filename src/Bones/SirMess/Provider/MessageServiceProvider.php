<?php

namespace Bones\SirMess\Provider;

use Bones\Message\Driver\Mongo\Driver;
use Bones\Message\Mailbox;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MessageServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['bones.message.driver'] = $app->share(function ($app) {
            $dbConfiguration = $app['config']['db'];

            return new Driver(
                $dbConfiguration['name'],
                $dbConfiguration['host'],
                $dbConfiguration['port'],
                $dbConfiguration['username'],
                $dbConfiguration['password'],
                $dbConfiguration['connect']
            );
        });

        $app['bones.message.mailbox'] = $app->share(function ($app) {
            return new Mailbox($app['bones.message.driver']);
        });
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
