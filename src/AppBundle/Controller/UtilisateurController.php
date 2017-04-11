<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Utilisateur;

class UtilisateurController extends Controller {
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs")
	 */
	public function getUtilisateursAction(Request $request) {
		$utilisateurs = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->findAll ();
		/* @var $utilisateurs Utilisateur[] */
		
		if (empty ( $utilisateurs )) {
			return new JsonResponse ( [ 
					'message' => 'Aucun utilisateur trouve' 
			], Response::HTTP_NOT_FOUND );
		}
		/*
		 * $formatted = [ ];
		 * foreach ( $utilisateurs as $utilisateur ) {
		 * $formatted [] = [
		 * 'uti_id' => $utilisateur->getId (),
		 * 'uti_nom' => $utilisateur->getNom (),
		 * 'uti_prenom' => $utilisateur->getPrenom (),
		 * 'uti_email' => $utilisateur->getEmail (),
		 * 'uti_mot_de_pass' => $utilisateur->getMotDePass ()
		 * ];
		 * }
		 */
		// Récupération du view handler
		// $viewHandler = $this->get('fos_rest.view_handler');
		
		// Création d'une vue FOSRestBundle
		// $view = View::create($formatted);
		/*$view = View::create ( $utilisateurs );
		$view->setFormat ( 'json' );*/
		
		// Gestion de la réponse
		// return $viewHandler->handle($view);
		//return $view;
		return $utilisateurs;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}")
	 */
	public function getUtilisateurAction($id, Request $request) {
		$utilisateur = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->find ( $id );
		/* @var $utilisateur Utilisateur */
		
		if (empty ( $utilisateur )) {
			return new JsonResponse ( [ 
					'message' => 'Utilisateur non trouve' 
			], Response::HTTP_NOT_FOUND );
		}
		
		/*$formatted = [ 
				'uti_id' => $utilisateur->getId (),
				'uti_nom' => $utilisateur->getNom (),
				'uti_prenom' => $utilisateur->getPrenom (),
				'uti_email' => $utilisateur->getEmail (),
				'uti_mot_de_pass' => $utilisateur->getMotDePass () 
		];
		*/
		// Récupération du view handler
		//$viewHandler = $this->get ( 'fos_rest.view_handler' );
		
		// Création d'une vue FOSRestBundle
		//$view = View::create ( $formatted );
		/*$view = View::create ( $utilisateur );
		$view->setFormat ( 'json' );*/
		
		// Gestion de la réponse
		//return $viewHandler->handle ( $view );
		//return $view;
		return $utilisateur;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Post("/utilisateurs")
	 */
	public function postUtilisateursAction(Request $request)
	{
		$utilisateur = new Utilisateur();
		$utilisateur->setNom($request->get('uti_nom'))
					->setPrenom($request->get('uti_prenom'))
					->setEmail($request->get('uti_email'))
					->setMotDePass($request->get('uti_mot_de_pass'));
		
		$em = $this->get('doctrine.orm.entity_manager');
		$em->persist($utilisateur);
		$em->flush();
		
		
	}
}