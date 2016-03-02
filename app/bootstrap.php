<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';

$app->register(new \Igorw\Silex\ConfigServiceProvider($app['root_path'] . "/app/config/config.$env.yml"));

$app['debug'] = $app['config']['debug'];

$app->register(new \Silex\Provider\SerializerServiceProvider());

$app->mount("/", new Bones\SirMess\Controller\IndexController());

