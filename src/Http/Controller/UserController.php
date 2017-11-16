<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 15/11/17
 * Time: 16:03
 */

namespace Jimmy\Silex\Http\Controller;


use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

class UserController implements ControllerProviderInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        return $controller;
    }
}