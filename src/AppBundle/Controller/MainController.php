<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }
}