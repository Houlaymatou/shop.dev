<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/categories", name="categories_list")
     * @Method("GET") 
     */
    public function indexAction()
    {  //Récupèration des données categories
      $categories = $this->getDoctrine()
                ->getRepository('AppBundle:Category')
                ->findAllSorted();
 
        return $this->render('category/index.html.twig', array(
        'title' => 'Categories',
        'categories' => $categories
        ));
    }

    /**
     * @Route("/admin/categories", name="categories_new")
     * @Method("POST")
     */ 
    public function newAction(Request $request)
    {
        $params = $request->request->all();

        $category = new Category();
        //$category->setName($_POST['name']) : accès à la super global $_POST
        $category->setName($params['name']);
        $category->setUrl($params['url']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category); 
        $em->flush();
        return $this->redirectToRoute('categories_list');
    }

   /**
     * @Route("/admin/categories/{id}/edit", name="category_edit")
     * @Method("GET")
     */ 
   public function editAction($id)
   
   {    //On récupère l'objet client grace à l'id
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);
        return $this->render('category/edit.html.twig', [
          'category' => $category,
          ]);
   }

   /**
     * @Route("/admin/categories/{id}/update", name="category_update")
     * @Method("POST")
     */ 
   //On récupère l'objet à mettre à jour grace à l'id methode 1
     /*
       public function updateAction($id, Request $request){
      $category = $this->getDoctrine()
       ->getRepository('AppBundle:Category')
       ->find($id);
       }
      
       */
   public function updateAction(Category $category, Request $request)
   
   {    
       
       //Methode2
        $params = $request->request->all();
        $category-> setName($params['name']);
        $category->setUrl($params['url']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($category); 
        $em->flush();
        return $this->redirectToRoute('categories_list');
   }

   /**
     * @Route("/admin/categories/{id}/delete", name="category_delete")
     */ 
   public function deleteAction(Category $category)
   
   {    //On récupère l'objet client grace à l'id
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
       
        //Redirection vers client
        return $this->redirectToRoute('categories_list');
   }

}
