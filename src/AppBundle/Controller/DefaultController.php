<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cursus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

        $em = $this->getDoctrine()->getManager();
        $cursussen = $em->getRepository("AppBundle:Cursus")->findAll();

        return $this->render('default/index.html.twig', [
            'cursussen' => $cursussen
        ]);
    }
    /**
     * @Route("/cursist", name="cursist")
     */
    public function cursistAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $cursussen = $em->getRepository("AppBundle:Cursus")->findAll();
        $role = $em->getRepository("UserBundle:Role")->findOneBy(['role'=>'ROLE_ADMIN']);

        return $this->render('default/cursist.html.twig', [
            'cursussen' => $cursussen,
            'admin' => $this->getUser()->hasRole($role)
        ]);
    }
    /**
     * @Route("/cursist/fancybox/{joinOrLeave}/{id}/{join}", defaults={"joinOrLeave"="join","id"="","join"="false"}, name="joinCursus")
     */
    public function joinCursusAction($joinOrLeave,$id,$join, Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $cursus = $em->getRepository("AppBundle:Cursus")->find($id);
        $canJoin = false;
        $canLeave = false;
        if($this->getUser() != null){

            if($join == "true"){
//                $cursus = new Cursus();
                $user = new User();
                if($joinOrLeave == "join"){
                    $this->getUser()->addWorkshop($cursus);
                }else{
//                    $cursus->removeCursisten($this->getUser());
                    $this->getUser()->removeWorkshop($cursus);
                }
                $em->persist($cursus);
                $em->flush();
            }
            if(!$this->getUser()->hasWorkshop($cursus)){
                $canJoin = true;
            }else{
                $canLeave = true;
            }
        }

        return $this->render('default/join.html.twig', [
            'cursus' => $cursus,
            'id' => $id,
            'can_join' => $canJoin,
            'can_leave' => $canLeave,

        ]);
    }
}
