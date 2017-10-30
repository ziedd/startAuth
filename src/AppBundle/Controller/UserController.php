<?php
/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 27/10/17
 * Time: 16:44
 */

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Form\UserRegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{

    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container=$container;
    }

    /**
     * @param Request $request
     * @Route("/register",name="user_register")
     */
    public function registerAction(Request $request)
    {
       $form = $this->createForm(UserRegistrationForm::class);

       $form->handleRequest($request);
       if($form->isValid())
       {
           /**
            * @var UserInterface $user
            */
           $user = $form->getData();
           $em = $this->getDoctrine()->getEntityManager();
           $em->persist($user);
           $em->flush();
           $this->addFlash('success','WELCOME'.$user->getUsername());

           return $this->get('security.authentication.guard_handler')
               ->authenticateUserAndHandleSuccess($user,
                   $request,
                   $this->get('app.security.login_form_authenticator'),
                   'main');
           return $this->redirectToRoute('homepage');

       }
        return $this->render('user/register.html.twig', [
          'form' => $form->createView()
        ]);
    }

}