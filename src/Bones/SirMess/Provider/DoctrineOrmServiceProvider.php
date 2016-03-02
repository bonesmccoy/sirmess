<?php


namespace Bones\SirMess\Provider;


use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use Doctrine\ORM\Tools\Setup;
use FOS\Message\Driver\Doctrine\ORM\DoctrineORMDriver;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DoctrineOrmServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     * @param Application $app
     * @throws \Doctrine\ORM\ORMException
     */
    public function register(Application $app)
    {
        $config = Setup::createConfiguration(true);

        /*
         * Tell Doctrine to use both your entities and the default entities from FOSMessage
         */
        $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver([
            __DIR__ . '/vendor/friendsofsymfony/message/src/Driver/Doctrine/ORM/Entity',
            __DIR__ . '/src',
        ], false));

        /* Use the Doctrine event manager to use your User model instead of the FOSMessage interface
        * in FOSMessage driver
        */
        $rtel = new ResolveTargetEntityListener();
        $rtel->addResolveTargetEntity('FOS\\Message\\Model\\PersonInterface', 'Bones\\SirMess\\Model\\User', []);

        $evm  = new EventManager();
        $evm->addEventListener(Events::loadClassMetadata, $rtel);

        /*
         * Finally, create the Doctrine EntityManager
         */
        $entityManager = EntityManager::create($app['config']['db'], $config, $evm);
        $app['doctrine'] = new DoctrineORMDriver($entityManager);
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
        // TODO: Implement boot() method.
    }
}
