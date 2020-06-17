<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
    * @Route("/", name="homePage")
    */
    public function indexAction()
    {
        
        return $this->render('default/index.html.twig');
    }

    
}

