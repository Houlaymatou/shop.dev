<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/categories")
     */
    public function indexAction()
    {     // Rechercher de la vue dans le bundle
        //return $this->render('AppBundle:Category:index.html.twig', array(   
        //));
       		
       		//comportement par défaut dans l'app
      return $this->render('category/index.html.twig', array());
    }

}
