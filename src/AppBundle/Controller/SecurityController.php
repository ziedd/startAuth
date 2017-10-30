<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 27/10/17
 * Time: 09:40
 */

namespace AppBundle\Controller;


use AppBundle\Form\LoginForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login",name="security_login")
     */
    public function loginAction(Request $request)
    {
        //$user = $request->getUser();



        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        //last username entred by the user

        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginForm::class,[
            '_username' => $lastUsername,
        ]);
        return $this->render('security/login.html.twig',array(
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,

    ));

    }

    /**
     * @Route("/logout",name="security_logout")
     */
    public function logout()
    {
        throw new \Exception("no way to do logout");

    }
}