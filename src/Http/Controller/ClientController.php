<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 02/11/17
 * Time: 17:49
 */

namespace Jimmy\Yap\Http\Controller;


use Doctrine\Common\Util\Debug;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController implements ControllerProviderInterface
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', [$this, 'homeAction'])
            ->bind('home');

        $controllers->match('/faq', [$this, 'contactAction'])
            ->bind('contact');

        $controllers->match('/layanan', [$this, 'supportAction'])
            ->bind('support');

        $controllers->get('/underconstruct', [$this, 'uConstructAction'])
            ->bind('u_construct');

        $controllers->get('/tentang', [$this, 'aboutAction'])
            ->bind('about');

        $controllers->get('/event-detail/{id}', [$this, 'eventDetailAction'])
            ->bind('event_detail');

        $controllers->get('/event', [$this, 'eventListAction'])
            ->bind('event_list');

        $controllers->get('/blog', [$this, 'blogListAction'])
            ->bind('blog_list');

        $controllers->get('/blog/{id}', [$this, 'blogDetailAction'])
            ->bind('blog_detail');

        $controllers->get('/promo', [$this, 'promoListAction'])
            ->bind('promo_list');

        $controllers->get('/promo/{id}', [$this, 'promoDetailAction'])
            ->bind('promo_detail');

        $controllers->get('/daftar-merchant', [$this, 'merchantRegAction'])
            ->bind('register_merchant');

        return $controllers;
    }

    public function merchantRegAction()
    {
      return $this->app['twig']->render('client/form.merchant.html.twig');
    }

    public function blogDetailAction(Request $request)
    {
        $data = $this->app['blog.repository']->findById($request->get('id'));

        return $this->app['twig']->render('client/event_detail.html.twig', [
            'data' => $data,
            'event_type' => 1,
        ]);
    }

    public function promoDetailAction(Request $request)
    {
        $data = $this->app['promo.repository']->findById($request->get('id'));

        return $this->app['twig']->render('client/event_detail.html.twig', [
            'data' => $data,
            'event_type' => 0,
        ]);
    }

    public function promoListAction(Request $request, $pageStart = 1)
    {
        $manager = $this->app['orm.em'];

        if ($request->get('page') != null) {
            $pageStart = $request->get('page');
        }

        $pageInfo['countAll'] = count($this->app['promo.repository']->findAll());

        $query = $manager->getRepository('Jimmy\Yap\Domain\Entity\Promo')
            ->createQueryBuilder('p')
            ->where('p.isDeleted = :isDeleted')->setParameter('isDeleted', 0)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->setMaxResults(10)
            ->setFirstResult(($pageStart - 1) * 10);

        return $this->app['twig']->render('client/event-type.html.twig', [
            'data' => $query->getResult(),
            'title' => 'Promo',
            'event_type' => 0,
            'pageInfo' => $pageInfo,
        ]);
    }

    public function blogListAction(Request $request, $pageStart = 1)
    {
        $manager = $this->app['orm.em'];

        if ($request->get('page') != null) {
            $pageStart = $request->get('page');
        }

        $pageInfo['countAll'] = count($this->app['blog.repository']->findAll());

        $query = $manager->getRepository('Jimmy\Yap\Domain\Entity\Blog')
            ->createQueryBuilder('b')
            ->where('b.isDeleted = :isDeleted')->setParameter('isDeleted', 0)
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->setMaxResults(10)
            ->setFirstResult(($pageStart - 1) * 10);

        return $this->app['twig']->render('client/event-type.html.twig', [
            'data' => $query->getResult(),
            'title' => 'Blog',
            'event_type' => 1,
            'pageInfo' => $pageInfo,
        ]);
    }

    public function eventListAction()
    {
        $manager = $this->app['orm.em'];
        $data['promo'] =
            $manager->getRepository('Jimmy\Yap\Domain\Entity\Promo')
                ->createQueryBuilder('p')
                ->where('p.isDeleted = :isDeleted')->setParameter('isDeleted', 0)
                ->orderBy('p.id', 'DESC')
                ->getQuery()
                ->setMaxResults(3)->getResult();

        $data['blog'] =
            $manager->getRepository('Jimmy\Yap\Domain\Entity\Blog')
                ->createQueryBuilder('b')
                ->where('b.isDeleted = :isDeleted')->setParameter('isDeleted', 0)
                ->orderBy('b.id', 'DESC')
                ->getQuery()
                ->setMaxResults(3)->getResult();

        return $this->app['twig']->render('client/event.html.twig', ['data' => $data]);
    }

    public function eventDetailAction()
    {
        return $this->app['twig']->render('client/blog_detail.html.twig');
    }

    public function blogAction()
    {
        return $this->app['twig']->render('client/blog.html.twig');
    }

    public function aboutAction()
    {
        return $this->app['twig']->render('client/tentang.html.twig');
    }

    public function uConstructAction()
    {
        return $this->app['twig']->render('client/underconstruct.html.twig');
    }

    public function homeAction(Request $request)
    {
        $manager = $this->app['orm.em'];

        $query = $manager->getRepository('Jimmy\Yap\Domain\Entity\Promo')
            ->createQueryBuilder('p')
            ->where('p.isDeleted = :isDeleted')->setParameter('isDeleted', 0)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->setMaxResults(3);

        return $this->app['twig']->render('home/index.html.twig', ['data' => $query->getResult()]);
    }

    public function contactAction(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $content['name'] = $request->get('name');
            $content['email'] = $request->get('email');
            $content['phone'] = $request->get('phone');
            $content['message'] = $request->get('message');

            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
                ->setUsername('yap.indonesia46@gmail.com')
                ->setPassword('Faster123');

            $message = \Swift_Message::newInstance();
            $message->setSubject('Website Feedback');
            $message->setFrom([$content['email'] => 'YAP! Website']);
            $message->setTo(['yap.bni46@gmail.com']);
            $message->setBody(
                $this->app['twig']->render(
                    'client/transport.html.twig',
                    [
                        'data' => $content,
                    ]
                ),
                'text/html'
            );

            $mailer = \Swift_Mailer::newInstance($transport);
            $mailer->send($message);

            return $this->app->redirect($this->app['url_generator']->generate('contact'));
        }

        return $this->app['twig']->render('client/contact.html.twig');
    }

    public function supportAction()
    {
        return $this->app['twig']->render('client/support.html.twig');
    }
}
