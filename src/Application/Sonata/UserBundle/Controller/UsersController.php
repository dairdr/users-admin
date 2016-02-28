<?php

namespace Application\Sonata\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UsersController.
 *
 *
 * @author Dair Diaz <dairdiazr@gmail.com>
 */
class UsersController extends Controller
{
    public function listAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('SonataUserBundle:Users:list.html.twig', array('users'=>$users));
    }

    public function singleShowAction($id)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->find($id);
        return $this->render('SonataUserBundle:Users:single.html.twig', array('user'=>$user));
    }

    public function connectFacebookWithAccountAction()
    {
        $fbService = $this->get('fos_facebook.user.login');
        //todo: check if service is successfully connected.
        $fbService->connectExistingAccount();
        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    public function loginFbAction() {
        return $this->redirect($this->generateUrl("_homepage"));
    }
}
