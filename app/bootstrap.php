<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);

$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';

use \Igorw\Silex\ConfigServiceProvider;
use \Silex\Provider\SerializerServiceProvider;

$appPath = $app['root_path'] . "/app";
$app->register(
    new ConfigServiceProvider($appPath . "/config/config.$env.yml")
);

$app['debug'] = $app['config']['debug'];

$app->register(new SerializerServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $appPath . "/logs/{$env}.log",
));


$app->mount("/", new Bones\SirMess\Controller\IndexController());

