<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\product;
use AppBundle\Entity\Category;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();
        return $this->render('default/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/{url}", name="url")
     */
    public function urlAction($url)
    {  //Verifier l'existence d'une url et recupèrer les produits de la catégorie
        $category = $this->getDoctrine()
         ->getRepository('AppBundle:Category')
         ->findByUrl($url);
         if($category){
            
            $products = $this->getDoctrine()
             ->getRepository('AppBundle:Product')
             ->findByCategory($category[0]->getId());
             
             //var_dump($products); 
             //on retourne un template pour l'affichage des produits
             return $this->render('product/gallery.html.twig', array(
                'products' => $products,

                ));
        
         }
        
        return new Response($url);
    }
    
}
     
