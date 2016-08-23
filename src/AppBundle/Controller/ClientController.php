<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Client;
/**
     * @Route("/users", name="clients")
     */

class ClientController extends Controller
{
    /**
     * @Route("/clients", name="clients")
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
        //**Enregister de nouveau client dans la bdd **

        $client = new Client();
        $client->setName($params['name']);
        $client->setAge($params['age']);
        //var_dump($client);
        $em = $this->getDoctrine()->getManager();//Entity manager ($em par convention)
        $em->persist($client); //persist commande d'insertion d'une requête préparer
        $em->flush();
        return $this->redirectToRoute('clients');
   }
  /**
     * @Route("/clients/{id}/delete", name="client_delete")
     */ 
   public function deleteAction($id)//la variable paramètre est strictement identique à la variable de la route
   //(id pour cet exemple)
   {    //On récupère l'objet client grace à l'id
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($id);
        //var_dump($client);
        //Suppression d'un objet
        $em->remove($client);
        $em->flush();
        //return new Response($id);
        //Redirection vers client
        return $this->redirectToRoute('clients');
   }
    
}
     
