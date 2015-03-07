<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('AppBundle::dashboard.html.twig');
    }
    
    /**
     * @Route("/send-form", name="send-form")
     * @Method({"POST"})
     */
    public function searchFormAction(Request $request)
    {
        $code = $request->request->get('code', null);
        $em = $this->getDoctrine()->getManager();
        $object = $em->getRepository('AppBundle:Student')->findOneByCode($code);
        $data = [
            'state' => 'ok',
        ];
        if ($object) {
            $data['template'] = $this->get('twig')->render('AppBundle::student_result.html.twig');
            $data['target'] = 'student';
        } else {
            $object = $em->getRepository('AppBundle:Teacher')->findOneByCode($code);
            if ($object) {
                $data['template'] = $this->get('twig')->render('AppBundle::teacher_result.html.twig');
                $data['target'] = 'teacher';
            } else {
                $data['state'] = 'error';
                $data['message'] = 'El código que ha ingresado es inválido, por favor, verifique.';
            }
        }
        $response = new JsonResponse($data);
        return $response;
    }
}
