<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    const STUDENT_TYPE = 'student';
    const TEACHER_TYPE = 'teacher';

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
     * @param Request $request
     * @return JsonResponse
     */
    public function searchFormAction(Request $request)
    {
        $code = $request->request->get('code', null);
        $em = $this->getDoctrine()->getManager();
        $object = $em->getRepository('AppBundle:Student')->findOneByCode($code);
        $data = ['state' => 'ok',];
        if ($object) {
            $candidates = $em->getRepository('AppBundle:Student')->findBy([
                'grade' => $object->getGrade(),
                //'group' => $object->getGroup(),
                //'time' => $object->getTime(),
                'isCandidate' => true,
                'isPersonero' => false,
            ]);
            $personeros = $em->getRepository('AppBundle:Student')->findBy([
                'isPersonero' => true,
            ]);
            $data['template'] = $this->get('twig')->render(
                'AppBundle::student_result.html.twig',
                [
                    'candidates' => $candidates,
                    'personeros' => $personeros,
                    'voter' => $object->getNames(),
                ]
            );
            $data['userType'] = DefaultController::STUDENT_TYPE;
            $data['userId'] = $object->getId();
        } else {
            $object = $em->getRepository('AppBundle:Teacher')->findOneByCode($code);
            if ($object) {
                $candidates = $em->getRepository('AppBundle:Teacher')->findBy([
                    'isCandidate' => true,
                ]);
                $data['template'] = $this->get('twig')->render(
                    'AppBundle::teacher_result.html.twig',
                    [
                        'candidates' => $candidates,
                        'voter' => $object->getNames(),
                    ]
                );
                $data['userType'] = DefaultController::TEACHER_TYPE;
                $data['userId'] = $object->getId();
            } else {
                $data['state'] = 'error';
                $data['message'] = 'El código que ha ingresado es inválido, por favor, verifique.';
            }
        }
        $response = new JsonResponse($data);
        return $response;
    }
    
    /**
     * @Route("/save-vote", name="save-vote")
     * @Method({"POST"})
     * @param Request $request
     */
    public function saveVoteAction(Request $request)
    {
        $data = $request->request->get('data', null);
        $resp = [
            'status' => 'ok',
            'message' => 'Hemos registrado su voto correctamente.'
        ];
        if ($data) {
            $em = $this->getDoctrine()->getManager();
            $object = json_decode($data);
            $temp = null;
            if ($object->userType === DefaultController::STUDENT_TYPE) {
                $temp = $em->getRepository('AppBundle:Student')->find($object->userId);
            } else {
                $temp = $em->getRepository('AppBundle:Teacher')->find($object->userId);
            }
            $this->assignVote($em, $object->selected, $temp, $resp);
        } else {
            $resp['status'] = 'error';
            $resp['message'] = 'No hay datos para hacer la operación.';
        }
        $response = new JsonResponse($resp);
        return $response;
    }
    
    /**
     * 
     * @param type $em
     * @param array $candidates
     * @param type $user
     * @param type $response
     */
    private function assignVote($em, $candidates, $user, &$response)
    {
        if ($user && !$user->getVoted()) {
            foreach ($candidates as $value) {
                $temp = null;
                if ($value->type === DefaultController::STUDENT_TYPE) {
                    $temp = $em->getRepository('AppBundle:Student')->find($value->id);
                } else {
                    $temp = $em->getRepository('AppBundle:Teacher')->find($value->id);
                }
                if ($temp) {
                    $temp->setVoteCounting($temp->getVoteCounting() + 1);
                }
            }
            $user->setVoted(true);
            $em->flush();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Usted ya ha votado, solo puede hacerlo una vez.';
        }
    }
}
