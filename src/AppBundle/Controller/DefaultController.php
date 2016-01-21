<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('default/cursist.html.twig', [
            'cursussen' => $cursussen
        ]);
    }
}
