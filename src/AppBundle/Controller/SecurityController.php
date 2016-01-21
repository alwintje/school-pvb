<?php
/**
 * Created by PhpStorm.
 * User: Alwin Kroesen
 * Date: 12-2-2015
 * Time: 12:10
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Configuration;
use UserBundle\Entity\User;
use UserBundle\Entity\Role;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error
            )
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/register", name="registerPage")
     */
    public function registerAction(Request $request){
        $form = $this->createRegisterForm();
        $response = $this->handleTheRequest($form, $request);

        return $this->render(
            'security/register.html.twig',
            array(
                'form' => $form->createView(),
                'response' => $response,
            )
        );
    }

    private function createRegisterForm(){
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('label' => 'Gebruikersnaam','attr'=> array('class'=>'form-control')))
            ->add('email', EmailType::class, array('label' => 'E-mail','attr'=> array('class'=>'form-control')))
            ->add('voornaam', TextType::class, array('label' => 'Voornaam','attr' => array('class'=>'form-control')))
            ->add('tussenVoegsels', TextType::class, array('label' => 'Tussenvoegsels','attr'=> array('class'=>'form-control'),'required' => false))
            ->add('achternaam', TextType::class, array('label' => 'Achternaam','attr'=> array('class'=>'form-control')))
            ->add('adres', TextType::class, array('label' => 'Adres','attr'=> array('class'=>'form-control')))
            ->add('woonplaats', TextType::class, array('label' => 'Woonplaats','attr'=> array('class'=>'form-control')))
            ->add('telefoon', TextType::class, array('label' => 'Telefoon','attr'=> array('class'=>'form-control')))
            ->add('password', RepeatedType::class, array('first_name'  => 'Wachtwoord', 'second_name' => 'Bevestig', 'type' => PasswordType::class, 'options'=>array('attr'=> array('class'=>'form-control'))))
            ->add('save', SubmitType::class, array('label' => 'Register','attr'=> array('class'=>'float')))
            ->getForm();
        return $form;
    }
    private function handleTheRequest($form,$request){

        $form->handleRequest($request);
        $response = "";
        if ($form->isValid()) {

            $user = new User();
            $user->setUsername($form->get('username')->getViewData());
            $user->setEmail($form->get('email')->getViewData());
            $user->setVoornaam($form->get('voornaam')->getViewData());
            $user->setTussenVoegsels($form->get('tussenVoegsels')->getViewData());
            $user->setAchternaam($form->get('achternaam')->getViewData());
            $user->setAdres($form->get('adres')->getViewData());
            $user->setWoonplaats($form->get('woonplaats')->getViewData());
            $user->setTelefoon($form->get('telefoon')->getViewData());

            $pass = $form->get('password')->getViewData();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $pass['Wachtwoord']);

            $user->setPassword($encoded);
            $user->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $byUser = $em->getRepository("UserBundle:User")->findOneBy(['username'=>$form->get('username')->getViewData()]);
            $byMail = $em->getRepository("UserBundle:User")->findOneBy(['email'=>$form->get('email')->getViewData()]);
            if(count($byUser) > 0 || count($byMail) > 0){
                return "Gebruikersnaam of email bestaat al.";
            }

//            if($this->admin) {
//                $role = $em->getRepository('UserBundle:Role')
//                    ->findOneBy(array(
//                        "role" => "ROLE_SUPER_ADMIN"
//                    ));
//            }else{
//            }
            $role = $em->getRepository('UserBundle:Role')
                ->findOneBy(array(
                    "role" => "ROLE_USER"
                ));
            $user->addRole($role);
            $user->serialize();

            $em->persist($user);
            $em->flush();

            $response = "Succesvol toegevoegd.";
        }
        return $response;
    }


}