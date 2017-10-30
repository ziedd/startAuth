<?php

namespace AppBundle\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Created by PhpStorm.
 * User: tritux
 * Date: 27/10/17
 * Time: 10:39
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

private $formFactory;
private $em;
private $router;
private $passwordEncoder;
    /**
     * LoginFormAuthenticator constructor.
     */
    public function __construct( \Symfony\Component\Form\FormFactory $formFactory,\Doctrine\ORM\EntityManager $em ,\Symfony\Component\Routing\RouterInterface $router,UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory =$formFactory;
        $this->em = $em ;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(\Symfony\Component\HttpFoundation\Request $request)
    {

        $isLoginSubmit = $request->getPathInfo()=='/login'& $request->isMethod('POST');

        if (!$isLoginSubmit){
            return ;
        }
        $form = $this->formFactory->create(\AppBundle\Form\LoginForm::class);
            $form->handleRequest($request);
            if ($form->isValid()){
                $data = $form->getData();
                $request->getSession()->set(Security::LAST_USERNAME,$data['_username']);
                return $data ;
            }
    }

    public function getUser($credentials, \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        $user = $this->em->getRepository('AppBundle:User')->findOneBy([
            'email'=>$username
        ]);

        if(!$user){
            return;
        }
        return $user;


    }

    public function checkCredentials($credentials, \Symfony\Component\Security\Core\User\UserInterface $user)
    {
        $password = $credentials['_password'];

        if($this->passwordEncoder->isPasswordValid($user, $password))
        {
            return true;
        }
        return false;

    }

    protected function getLoginUrl()
    {

        return $this->router->generate('security_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
       return  $this->router->generate('homepage');
    }
}