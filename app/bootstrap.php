<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';

use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use \Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use \Silex\Provider\SerializerServiceProvider;

$app->register(
    new ConfigServiceProvider($app['root_path'] . "/app/config/config.$env.yml")
);

$app['debug'] = $app['config']['debug'];

$app->register(new SerializerServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
    'db.options' =>$app['config']['db.options'],
));

$app->register(new DoctrineOrmServiceProvider, array(
    'orm.proxies_dir' => $app['root_path'] . '/app/cache/proxies',
    'orm.em.options' => array(
        'mappings' => array(
            // Using actual filesystem paths
            array(
                'type' => 'annotation',
                'namespace' => 'FOS\Message\Driver\Doctrine\ORM\Entity',
                'path' => $app['root_path']. '/vendor/friendsofsymfony/message/src/Driver/Doctrine/ORM/Entity',
            )
        ),
    ),
));

$app->mount("/", new Bones\SirMess\Controller\IndexController());

