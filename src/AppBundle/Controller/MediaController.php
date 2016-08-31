<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\MediaType;
use AppBundle\Entity\Media;

class MediaController extends Controller
{   /**
     * @Route("/admin/media", name="media")
     */
	public function indexAction(Request $request)
	{
	
	  $medias = $this->getDoctrine()->getRepository('AppBundle:Media')->findAll();

	  return $this->render('media/index.html.twig', array(
	  	 'title' => "Images",
          'medias' => $medias,
           
        ));
	}

    /**
     * @Route("/admin/media/new", name="media_new")
     */
    public function newAction(Request $request)
    {	
    	$media = new Media();
    	$form = $this->createForm(MediaType::class, $media);
		$form->handleRequest($request);
		if($form->isSubmitted()){
			//dossier de stockage des images postées
			$dir = $this->get('kernel')->getRootDir().'/../web/files';
			$file = $media->getFile();//renvoie un objet de type uploadedFile
			$filename = $file->getClientOriginalName();//on récupère le nom d'origine du fichier posté
			//Envoie du fichier sur le serveur
			$file->move($dir, $filename);
			//Enregistrement
			$em = $this->getDoctrine()->getManager();
			//modification de la propriété file des propriétes files et product
			$media->setFile($filename);
			$media->setProduct($media->getProduct()->getId());
			//Enregistrement dans la base
			$em->persist($media);
			$em->flush();

			
		}
        return $this->render('media/new.html.twig', array(
           
           'form' => $form->createView(),
        ));
    }

}
