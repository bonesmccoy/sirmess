<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';

use \Igorw\Silex\ConfigServiceProvider;
use \Silex\Provider\SerializerServiceProvider;

$app->register(
    new ConfigServiceProvider($app['root_path'] . "/app/config/config.$env.yml")
);

$app['debug'] = $app['config']['debug'];

$app->register(new SerializerServiceProvider());

$app->mount("/", new Bones\SirMess\Controller\IndexController());

