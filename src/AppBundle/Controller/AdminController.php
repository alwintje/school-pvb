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
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;


define("REQUEST_CURSUS_SOORT", "cursus_soort");
define("REQUEST_CURSUS", "cursus");

class AdminController extends Controller
{
    private $response = "";
    private $responseCursusSoort = "";
    private $responseCursus = "";



    /**
     * @Route("/admin/{edit}/{id}", defaults={"edit"="0","id"="0"}, name="adminpage")
     */
    public function adminAction($edit,$id, Request $request)// Admin page.
    {
        // Set defaults
        $cursusSoort = new SoortCursus();
        $cursus = new Cursus();

        $em = $this->getDoctrine()->getManager();

//        $requestEditCursusSoort = "cursus_soort"

        // On action
        if($edit != null){
            if($edit == REQUEST_CURSUS_SOORT){
                $cursusSoort = $em->getRepository("AppBundle:SoortCursus")->find($id);
                if(count($cursusSoort) < 1){
                    $cursusSoort = new SoortCursus();
                }
            }elseif($edit == REQUEST_CURSUS){
                $cursus = $em->getRepository("AppBundle:Cursus")->find($id);
                if(count($cursus) < 1){
                    $cursus = new Cursus();
                }
            }
        }

        // Build SoorCursus form
        $cursusSoortForm = $this->createFormBuilder($cursusSoort, array('attr' => array('id' => "form")))
            ->add('naam', TextType::class, array('label' => 'Naam','attr' => array("class" => "form-control")))

            ->add('prijs', IntegerType::class, array('label' => 'Prijs (in centen!)','attr' => array("class" => "form-control")))

            ->add('save', SubmitType::class, array('label' => ($edit == REQUEST_CURSUS_SOORT ? "Aanpassen" : "Toevoegen"),'attr' => array("class" => "form-control")))
            ->getForm();

        // Build Cursus form
        $cursusForm = $this->createFormBuilder($cursus, array('attr' => array('id' => "form")))
            ->add('soortCursus', EntityType::class, array(
                'class' => 'AppBundle:SoortCursus',
                'choice_label' => 'naam'))

            ->add('beginDatum', DateType::class, array('label' => 'Begin datum','attr' => array("class" => "form-control")))
            ->add('eindDatum', DateType::class, array('label' => 'Eind datum','attr' => array("class" => "form-control")))
            ->add('image', TextType::class, array('label' => 'Afbeelding url','attr' => array("class" => "form-control")))

            ->add('save', SubmitType::class, array('label' => ($edit == REQUEST_CURSUS ? "Aanpassen" : "Toevoegen"),'attr' => array("class" => "form-control")))
            ->getForm();

        // Get all cursussen and all CursusSoorten
        $cursussen = $em->getRepository("AppBundle:Cursus")->findBy([],["beginDatum" => "ASC"],10);
        $cursusSoorten = $em->getRepository("AppBundle:SoortCursus")->findBy([],["naam" => "ASC"],10);


        //Handle request
        if($request !== false){
            if($request->getMethod() == "POST"){
                $data = $request->request->all();
                if(isset($data['form']['prijs'])){

                    $cursusSoortForm->handleRequest($request);
                    if ($cursusSoortForm->isValid()) {
                        $em->persist($cursusSoort);
                        $em->flush();
                        $this->responseCursusSoort = "Succesvol ".($edit == REQUEST_CURSUS_SOORT ? "aangepast!" : "toegevoegd!");
                    }
                }else {
                    $cursusForm->handleRequest($request);
                    if ($cursusForm->isValid()) {
                        $em->persist($cursus);
                        $em->flush();
                        $this->responseCursus = "Succesvol ".($edit == REQUEST_CURSUS ? "aangepast!" : "toegevoegd!");
                    }
                }
            }
        }
        // Get all users
        $users = $em->getRepository("UserBundle:User")->findAll();
        $me = $this->getUser();
        // Render view
        return $this->render('default/admin.html.twig',[
            'cursusSoortForm' => $cursusSoortForm->createView(),
            'cursusForm' => $cursusForm->createView(),
            'response_cursus_soort' => $this->responseCursusSoort,
            'response_cursus' => $this->responseCursus,
            'cursussen' => $cursussen,
            'cursusSoorten' => $cursusSoorten,
            'users' => $users,
            'me' => $me,
        ]);
    }



    /**
     * @Route("/delete/{type}/{id}", defaults={"type"="","id"=""}, name="deletePage")
     */
    public function deleteAction($type, $id, Request $request)// Delete a cursusSoort or cursus
    {
        // replace this example code with whatever you need

        $em = $this->getDoctrine()->getManager();

        $db = "";
        if($type == "cursusSoort"){
            $db = "SoortCursus";
        }
        if($type == "cursus"){
            $db = "Cursus";
        }
        $entity = $em->getRepository("AppBundle:".$db)->find($id);
        if(count($entity) != 1){
            return $this->redirectToRoute('adminpage');
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('adminpage');

    }


    /**
     * @Route("/edit/{type}/{id}", defaults={"type"="","id"=""}, name="editPage")
     */
    public function editAction($type, $id, Request $request)// Edit a cursusSoort or cursus
    {
        $em = $this->getDoctrine()->getManager();

        $db = "";
        if($type == "cursusSoort"){
            $db = "SoortCursus";
        }
        if($type == "cursus"){
            $db = "Cursus";
        }
        $entity = $em->getRepository("AppBundle:".$db)->find($id);
        if(count($entity) != 1){
            return $this->redirectToRoute('adminpage');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute('adminpage');

    }



    /**
     * @Route("/admin/{id}/{action}", defaults={"id"="","action"=""}, name="editUser")
     */
    public function editUserAction($id, $action, Request $request) // Edit user
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("UserBundle:User")->find($id);


        // Make user admin or normal user
        if($action == "role") {
            $adminRole = $em->getRepository("UserBundle:Role")->findOneBy(["role" => "ROLE_ADMIN"]);
            $userRole = $em->getRepository("UserBundle:Role")->findOneBy(["role" => "ROLE_USER"]);

            if ($user->hasRole($adminRole)) {
                $user->removeRole($adminRole);
                $user->addRole($userRole);
            } else {
                $user->addRole($adminRole);
                $user->removeRole($userRole);
            }

        }elseif($action == "active"){ // Make user active or not
            // set the opposite of active
            $user->setIsActive(!$user->getIsActive());
        }

        $em->persist($user);
        $em->flush();

        // Redirect back to the admin page
//        return new Response("");
        return $this->redirectToRoute('adminpage');

    }
}
