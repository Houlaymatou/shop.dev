<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Entity\Media;

class ProductController extends Controller
{
	/**
     * @Route("/admin/products", name="products_list")
     */
	public function indexAction(Request $request)
	{	//Construction du formulaire
		$product = new Product();
		$form = $this->createForm(ProductType::class, $product);
		$form->handleRequest($request);
		if($form->isSubmitted()){
			//si requête post alors enregistrement des données
			$product = $form->getData();
			//on récupère que l'id de la categorie
			$category_id = $product->getCategory()->getId();
			$product->setCategory($category_id);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();
		}
        $products = $this->getDoctrine()
        ->getRepository('AppBundle:Product')
        ->findAll();

        //On veut récupèrer tous les produits avec les medias associées
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("
        	SELECT p FROM AppBundle:Product p 
        	JOIN AppBundle:Media m 
        	WHERE p.id = m.product
        	");
        $productsMedia = $query->getResult();
        //var_dump($productsMedia);

		return $this->render('product/index.html.twig', array(
				'form' => $form->createView(),
				'products' => $products,
				

			));
	}

	/**
	* @Route("/admin/products/new", name="product_new")
	*/
    public function newAction(Request $request)
    {
    	return new Response('new action');
    }
}

