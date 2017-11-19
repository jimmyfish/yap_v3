<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 15/11/17
 * Time: 16:03
 */

namespace Jimmy\Yap\Http\Controller;

use Doctrine\Common\Util\Debug;
use Jimmy\Yap\Domain\Entity\Blog;
use Jimmy\Yap\Domain\Entity\Promo;
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

        $controller->match('/promo/create', [$this, 'promoCreateAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_promo_create')
            ->method('GET|POST');

        $controller->get('/promo/delete/{id}', [$this, 'promoDeleteTempAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_promo_delete_temp');

        $controller->match('/promo/edit/{id}', [$this, 'promoEditAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_promo_edit');

        // BLOG

        $controller->match('/blog/create', [$this, 'blogCreateAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_blog_create')
            ->method('GET|POST');

        $controller->get('/blog/delete/{id}', [$this, 'blogDeleteTempAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_blog_delete_temp');

        $controller->match('/blog/edit/{id}', [$this, 'blogEditAction'])
            ->before([$this, 'credentialChecks'])
            ->bind('admin_blog_edit');

        $controller->get('/logout', [$this, 'logoutAction'])
            ->bind('admin_logout');

        return $controller;
    }

    public function blogEditAction(Request $request, $id)
    {
        $manager = $this->app['orm.em'];
        $data = $this->app['blog.repository']->findById($id);

        if ($request->getMethod() === 'POST') {
            if ($data instanceof Blog) {
                if ($request->files->get('_img') != null) {
                    $oldImg = $data->getImage();

                    $newImg = $request->files->get('_img');
                    $newImgName = md5(uniqid()) . '.'.$newImg->guessExtension();

                    $data->setImage($newImgName);
                    $dirName = $this->app['foto.path'].'/blog/';

                    $newImg->move($dirName, $newImgName);

                    unlink($dirName . $oldImg);
                }

                $data->setTitle($request->get('_title'));
                $data->setContent($request->get('_content'));
                $data->setDate(new \DateTime());
                $data->setAuthor(
                    $this->app['user.repository']->findByUsername(
                        $this->app['session']->get('uname')['value']
                    )
                );

                $manager->persist($data);
                $manager->flush();

                return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
            }
        }

        return $this->app['twig']->render('writer/form.blog.html.twig', [
            'title' => 'Edit',
            'data' => $data,
        ]);
    }

    public function blogDeleteTempAction(Request $request, $id)
    {
        $data = $this->app['blog.repository']->findById($id);

        if ($data instanceof Blog) {
            $data->setIsDeleted(1);
            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
        }

        return null;
    }

    public function blogCreateAction(Request $request)
    {
        $manager = $this->app['orm.em'];

        if ($request->getMethod() === 'POST') {
            $data = new Blog();

            $data->setTitle($request->get('_title'));
            $data->setContent($request->get('_content'));
            $data->setDate(new \DateTime());
            $data->setAuthor(
                $this->app['user.repository']->findByUsername(
                    $this->app['session']->get('uname')['value']
                )
            );

            $img = $request->files->get('_img');
            $imgName = md5(uniqid()) . '.'. $img->guessExtension();
            $dirName = $this->app['foto.path'] . '/blog/';

            $data->setImage($imgName);

            $manager->persist($data);
            $manager->flush();

            $img->move($dirName, $imgName);

            return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
        }

        return $this->app['twig']->render('writer/form.blog.html.twig', ['title' => 'Buat']);
    }

    public function promoEditAction(Request $request, $id)
    {
        $manager = $this->app['orm.em'];
        $data = $this->app['promo.repository']->findById($id);

        if ($request->getMethod() === 'POST') {
            if ($data instanceof Promo) {
                if ($request->files->get('_img') != null) {
                    $oldImg = $data->getImage();

                    $newImg = $request->files->get('_img');
                    $newImgName = md5(uniqid()) . '.'.$newImg->guessExtension();

                    $data->setImage($newImgName);
                    $dirName = $this->app['foto.path'].'/promo/';

                    $newImg->move($dirName, $newImgName);

                    unlink($dirName . $oldImg);
                }

                $data->setTitle($request->get('_title'));
                $data->setContent($request->get('_content'));
                $data->setKodePromo($request->get('_kode-promo'));
                $data->setTanggalBerlakuAwal($request->get('_start-date'));
                $data->setTanggalBerlakuAkhir($request->get('_end-date'));
                $data->setAuthor($this->app['user.repository']->findByUsername(
                    $this->app['session']->get('uname')['value']
                ));

                $manager->persist($data);
                $manager->flush();
            }

            return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
        }

        return $this->app['twig']->render('writer/form.promo.html.twig', [
            'title' => 'Edit',
            'data' => $data,
        ]);
    }

    public function promoDeleteTempAction($id)
    {
        $data = $this->app['promo.repository']->findById($id);

        if ($data instanceof Promo) {
            $data->setIsDeleted(1);

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();
        }

        return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
    }

    public function promoCreateAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = new Promo();
            $data->setTitle($request->get('_title'));
            $data->setContent($request->get('_content'));
            $data->setAuthor(
                $this->app['user.repository']->findByUsername(
                    $this->app['session']->get('uname')['value']
                )
            );
            $data->setIsDeleted(0);
            $img = $request->files->get('_img');

            $imgName = md5(uniqid()) . '.'.$img->guessExtension();

            $data->setImage($imgName);

            $data->setKodePromo($request->get('_kode-promo'));

            $data->setTanggalBerlakuAwal($request->get('_start-date'));
            $data->setTanggalBerlakuAkhir($request->get('_end-date'));

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            $dirName = $this->app['foto.path'].'/promo/';

            $img->move($dirName, $imgName);

            return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
        }

        return $this->app['twig']->render('writer/form.promo.html.twig', ['title' => 'Buat']);
    }

    public function logoutAction()
    {
        $this->app['session']->clear();
        return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
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
        $data['promo'] = $this->app['promo.repository']->findByState(0);
        $data['blog'] = $this->app['blog.repository']->findByState(0);

        return $this->app['twig']->render('writer/index.html.twig', [
            'data' => $data,
        ]);
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

                if ($data != null) {
                    if ($data->getPassword() == sha1(md5($request->get('_password')))) {

                        $session->set('uname', ['value' => $data->getUsername()]);
                        $session->set('role', ['value' => $data->getRole()]);
                    }
                } else {
                    return $this->app->redirect($this->app['url_generator']->generate('admin_login'));
                }

                return $this->app->redirect($this->app['url_generator']->generate('admin_index'));
            }
        }

        return $this->app['twig']->render('writer/login.html.twig');
    }
}
