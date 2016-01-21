<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cursus;
use AppBundle\Entity\SoortCursus;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    private $response = "";
    /**
     * @Route("/admin", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need

        $em = $this->getDoctrine()->getManager();


        $cursusSoort = new SoortCursus();
        $cursusSoortForm = $this->createFormBuilder($cursusSoort, array('attr' => array('id' => "form")))
            ->add('naam', TextType::class, array('label' => 'Naam','attr' => array("class" => "form-control")))

            ->add('prijs', IntegerType::class, array('label' => 'Prijs','attr' => array("class" => "form-control")))

            ->add('save', SubmitType::class, array('label' => 'Toevoegen','attr' => array("class" => "form-control")))
            ->getForm();


        $cursus = new Cursus();
//        $cursus->
        $cursusForm = $this->createFormBuilder($cursus, array('attr' => array('id' => "form")))
            ->add('soortCursus', EntityType::class, array(
                'class' => 'AppBundle:SoortCursus',
                'choice_label' => 'naam'))

            ->add('beginDatum', DateType::class, array('label' => 'Begin datum','attr' => array("class" => "form-control")))
            ->add('eindDatum', DateType::class, array('label' => 'Eind datum','attr' => array("class" => "form-control")))
            ->add('image', TextType::class, array('label' => 'Afbeelding url','attr' => array("class" => "form-control")))

            ->add('save', SubmitType::class, array('label' => 'Toevoegen','attr' => array("class" => "form-control")))
            ->getForm();

        $this->response = "";
        $cursussen = $em->getRepository("AppBundle:Cursus")->findBy([],["beginDatum" => "ASC"],10);

        if($request !== false){
            if($request->getMethod() == "POST"){
                $data = $request->request->all();
                if(isset($data['form']['prijs'])){

                    $cursusSoortForm->handleRequest($request);
                    if ($cursusSoortForm->isValid()) {
                        $em->persist($cursusSoort);
                        $em->flush();
                    }
                }else {
                    $cursusForm->handleRequest($request);
                    if ($cursusForm->isValid()) {
                        $em->persist($cursus);
                        $em->flush();
                    }
                }
            }
        }

//        $this->text['errors'] = array();
//        $formRoom = $this->addRoom(false,$isRoom ? $id : false, $translator);
//        $this->text['formBooking'] = $formBooking->createView();
        return $this->render('default/admin.html.twig',[
            'cursusSoortForm' => $cursusSoortForm->createView(),
            'cursusForm' => $cursusForm->createView(),
            'response' => $this->response,
            'cursussen' => $cursussen
        ]);
    }
}
