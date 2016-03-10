<?php


$loader = require_once __DIR__. '/../vendor/autoload.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_USER_DEPRECATED);

use \Igorw\Silex\ConfigServiceProvider;
use \Silex\Provider\SerializerServiceProvider;
use Silex\Application;


$env = getenv('APP_ENV') ? getenv('APP_ENV') : 'dev';

$app = new Application();
$applicationPath = __DIR__;

$app['env'] = $env;
$app->register(new ConfigServiceProvider($applicationPath . "/config/config.$env.yml"));

$app['root_path'] = realpath(__DIR__ . '/../');
$app['debug'] = $app['config']['debug'];


$app->register(new SerializerServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $applicationPath . "/logs/{$env}.log",
));

$app->register(new Bones\SirMess\Provider\MessageServiceProvider());


$app->mount("/mailbox", new Bones\SirMess\Controller\MailboxControllerProvider());

