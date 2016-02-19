<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cursus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) // Home page
    {

        $em = $this->getDoctrine()->getManager();
        $cursussen = $em->getRepository("AppBundle:Cursus")->findAll();

        return $this->render('default/index.html.twig', [
            'cursussen' => $cursussen
        ]);
    }
    /**
     * @Route("/cursist", name="cursist")
     */
    public function cursistAction(Request $request) // Home page when cursist is logged in
    {
        // If the user is not active anymore
        if(!$this->getUser()->getIsActive()){
            return $this->redirectToRoute('logout');
        }
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
    public function joinCursusAction($joinOrLeave,$id,$join, Request $request) // Fancybox page for joining/leaving a cursus
    {
        // get cursus
        $em = $this->getDoctrine()->getManager();
        $cursus = $em->getRepository("AppBundle:Cursus")->find($id);

        //set default values
        $canJoin = false;
        $canLeave = false;

        // Check if is logged in
        if($this->getUser() != null){

            if($join == "true"){
//                $cursus = new Cursus();
                $user = new User();
                if($joinOrLeave == "join"){
                    $this->getUser()->addWorkshop($cursus); // Join cursus
                }else{
//                    $cursus->removeCursisten($this->getUser());
                    $this->getUser()->removeWorkshop($cursus); // Leave cursus
                }
                // save
                $em->persist($cursus);
                $em->flush();
            }
            // Button for joining or leaving the cursus
            if(!$this->getUser()->hasWorkshop($cursus)){
                $canJoin = true;
            }else{
                $canLeave = true;
            }
        }
        // Render view
        return $this->render('default/join.html.twig', [
            'cursus' => $cursus,
            'id' => $id,
            'can_join' => $canJoin,
            'can_leave' => $canLeave,

        ]);
    }
    /**
     * @Route("/account/edit", name="account")
     */
    public function accountAction(Request $request) // Edit account
    {
        // Create form for editing user
        $form = $this->createFormBuilder($this->getUser())
            ->add('username', TextType::class, array('label' => 'Gebruikersnaam','attr'=> array('class'=>'form-control')))
            ->add('email', EmailType::class, array('label' => 'E-mail','attr'=> array('class'=>'form-control')))
            ->add('voornaam', TextType::class, array('label' => 'Voornaam','attr' => array('class'=>'form-control')))
            ->add('tussenVoegsels', TextType::class, array('label' => 'Tussenvoegsels','attr'=> array('class'=>'form-control'),'required' => false))
            ->add('achternaam', TextType::class, array('label' => 'Achternaam','attr'=> array('class'=>'form-control')))
            ->add('adres', TextType::class, array('label' => 'Adres','attr'=> array('class'=>'form-control')))
            ->add('woonplaats', TextType::class, array('label' => 'Woonplaats','attr'=> array('class'=>'form-control')))
            ->add('telefoon', TextType::class, array('label' => 'Telefoon','attr'=> array('class'=>'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Wijzig','attr'=> array('class'=>'float')))
            ->getForm();
        // Handle request
        $response = $this->handleTheRequest($form, $request);

        // Render view
        return $this->render('security/register.html.twig', [
                'form' => $form->createView(),
                'response' => $response,
                'edit' => true
            ]);
    }

    // Handle edit account form and return response
    private function handleTheRequest($form,$request){

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        $response = "";
        if ($form->isValid()) {


            // Check for editing username or email.
            $checkUsername = $em->getRepository("UserBundle:User")->findBy(array("username"=>$form->get('username')->getViewData()));
            $checkEmail = $em->getRepository("UserBundle:User")->findBy(array("username"=>$form->get('email')->getViewData()));
            $noExist = 0;
            foreach($checkUsername as $u){
                if($u != $this->getUser()){$noExist++;}
            }
            foreach($checkEmail as $u){
                if($u != $this->getUser()){$noExist++;}
            }
            if($noExist > 0){
                return "Gebruikersnaam of email bestaat al";
            }


            // Set new values
            $user = $this->getUser();
            $user->setUsername($form->get('username')->getViewData());
            $user->setEmail($form->get('email')->getViewData());
            $user->setVoornaam($form->get('voornaam')->getViewData());
            $user->setTussenVoegsels($form->get('tussenVoegsels')->getViewData());
            $user->setAchternaam($form->get('achternaam')->getViewData());
            $user->setAdres($form->get('adres')->getViewData());
            $user->setWoonplaats($form->get('woonplaats')->getViewData());
            $user->setTelefoon($form->get('telefoon')->getViewData());

            $user->serialize();

            $em->persist($user);
            $em->flush();

            $response = "Succesvol gewijzigd";
        }
        return $response;
    }
}
