<?php
namespace Application\Sonata\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller {
    
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(){
        return $this->render('CTLAppBundle:Dashboard:layout.html.twig');
    }
}