<?php

require_once __DIR__. '/../vendor/autoload.php';

$app = new Silex\Application();

$app['root_path'] = realpath(__DIR__ . '/../');
include $app['root_path'] . "/app/bootstrap.php";

$app->run();
