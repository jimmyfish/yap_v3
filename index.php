<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 15/11/17
 * Time: 16:01
 */

$loader = require __DIR__ . '/vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$config = require __DIR__ . '/app/config.php';

$app = new \Silex\Application($config['common']);

require 'bootstrap.php';

$app->mount('/', new \Jimmy\Yap\Http\Controller\ClientController($app));
$app->mount('/blog', new \Jimmy\Yap\Http\Controller\BlogController($app));
$app->mount('/penulis', new \Jimmy\Yap\Http\Controller\UserController($app));

$app->run();
