<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * @Route("/clients")
     */

    public function indexAction(Request $request)
    {
        $clients1 = [
        ['name' => 'Client 1', 'age' => 78],
        ['name' => 'Client 2',  'age' => 68],
        ['name' => 'Client 3',  'age' => 38],
        ];

        //Interogation de la bdd
        $clients = $this->getDoctrine()
                ->getRepository('AppBundle:Client')
                ->findAllSorted();

        return $this->render('client/index.html.twig', [
           'title'=> 'Liste de mes clients',
           'clients' => $clients
        ]);
    }

   /**
     * @Route("/clients/new")
     * @Method("POST")
     */ 

   public function newAction(Request $request)
   {    //Récuperation des données postées
        //$test = $request->get('name');
        //var_dump($request);
        //var_dump($request->request);
        //var_dump($request->request->all());
        $params = $request->request->all();//On recupère tous les paramètres d'une requete POST; cf api.symfony.com
        //var_dump($test['name']);
        return new Response($params['name']);
   }
    
}
     
