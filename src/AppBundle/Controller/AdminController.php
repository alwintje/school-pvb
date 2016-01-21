<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SoortCursus;
use Doctrine\DBAL\Types\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need

//        $em = $this->getDoctrine()->getManager();
//        $cursussen = $em->getRepository("AppBundle:Cursus")->findAll();
        $cursusSoort = new SoortCursus();
        $cursusSoort->
        $cursusSoortForm = $this->createFormBuilder($cursusSoort, array('attr' => array('id' => "reservations")))
            ->add('naam', TextType::class, array('label' => 'Naam','attr' => array("class" => "form-control")))

            ->add('prijs', IntegerType::class, array('label' => 'Prijs','attr' => array("class" => "form-control")))

            ->add('save', SubmitType::class, array('label' => 'Toevoegen','attr' => array("class" => "form-control")))
            ->getForm();

        $this->text['errors'] = array();
        $formRoom = $this->addRoom(false,$isRoom ? $id : false, $translator);
        if($request !== false){
            if($request->getMethod() == "POST"){

                $data = $request->request->all();
                if(isset($data['form']['seats'])){

                    $formRoom = $this->addRoom($request,$isRoom ? $id : false,$translator);
                }else {
                    $formBooking->handleRequest($request);
                    if ($formBooking->isValid()) {
                        $bookingCheck = new BookingController();
                        $this->text['errors'] = $bookingCheck->checkBooking($booking, $this->getDoctrine()->getManager(), ($booking == null ? false : $id));
                    }
                }
            }
        }
        $this->text['formBooking'] = $formBooking->createView();
        return $this->render('default/admin.html.twig');
    }
}
