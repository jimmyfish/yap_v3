<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 15/11/17
 * Time: 16:03
 */

namespace Jimmy\Yap\Http\Controller;

use Doctrine\Common\Util\Debug;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $controller->get('/', [$this, 'adminIndexAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_index');

        $controller->match('/masuk', [$this, 'loginAdminAction'])
            ->bind('admin_login')
            ->method('GET|POST');

        $controller->get('/logout', [$this, 'logoutAction'])
            ->bind('admin_logout');

        return $controller;
    }

    public function logoutAction()
    {
        $this->app['session']->clear();
        return 'OK';
    }

    public function credentialChecks()
    {
        $session = $this->app['session'];
        if ($session->get('role')['value'] == null) {
            return $this->app->redirect($this->app['url_generator']->generate('admin_login'));
        }

        return null;

    }

    public function adminIndexAction()
    {
        return $this->app['twig']->render('writer/index.html.twig');
    }

    public function loginAdminAction(Request $request)
    {
        $session = $this->app['session'];

        if ($session->get('role')['value'] == 'admin') {
            return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
        }

        if ($request->getMethod() === 'POST') {
            if (!$request->get('_username') == null) {
                $data = $this->app['user.repository']->findByUsername($request->get('_username'));

                if ($data->getPassword() == sha1(md5($request->get('_password')))) {

                    $session->set('uname', ['value' => $data->getUsername()]);
                    $session->set('role', ['value' => $data->getRole()]);
                }

                return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
            }
        }

        return $this->app['twig']->render('writer/login.html.twig');
    }
}
