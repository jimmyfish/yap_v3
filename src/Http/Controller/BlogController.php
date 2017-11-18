<?php

namespace Jimmy\Yap\Http\Controller;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

Class BlogController implements ControllerProviderInterface
{
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        $controller->get('/', [$this, 'blogIndexAction'])
            ->bind('blog_index');

        return $controller;
    }

    public function blogIndexAction()
    {
        return $this->app['twig']->render('client/blog.html.twig');
    }
}
