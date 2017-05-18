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
use AppBundle\Form\Type\UtilisateurType;
use Doctrine\ORM\Query\Expr\From;
use AppBundle\Entity\AlbumPartage;

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
		/*
		 * $view = View::create ( $utilisateurs );
		 * $view->setFormat ( 'json' );
		 */
		
		// Gestion de la réponse
		// return $viewHandler->handle($view);
		// return $view;
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
		
		/*
		 * $formatted = [
		 * 'uti_id' => $utilisateur->getId (),
		 * 'uti_nom' => $utilisateur->getNom (),
		 * 'uti_prenom' => $utilisateur->getPrenom (),
		 * 'uti_email' => $utilisateur->getEmail (),
		 * 'uti_mot_de_pass' => $utilisateur->getMotDePass ()
		 * ];
		 */
		// Récupération du view handler
		// $viewHandler = $this->get ( 'fos_rest.view_handler' );
		
		// Création d'une vue FOSRestBundle
		// $view = View::create ( $formatted );
		/*
		 * $view = View::create ( $utilisateur );
		 * $view->setFormat ( 'json' );
		 */
		
		// Gestion de la réponse
		// return $viewHandler->handle ( $view );
		// return $view;
		return $utilisateur;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/albumPartages")
	 */
	public function getUtilisateurAlbumPartagesAction($id, Request $request) {
		
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT alb.id, alb.titre, alb.date_creation, alb.uti_id
				FROM AppBundle:Album alb
				JOIN AppBundle:AlbumPartage alp WITH alb.id = alp.alb_id
				JOIN AppBundle:Utilisateur uti WITH uti.id = alp.uti_id
				WHERE uti.id = :uti_id'
				)
				->setParameter('uti_id', $id);
				
		$albums = $query->getResult();
		
		return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/albums")
	 */
	public function getUtilisateurAlbumAction($id, Request $request) {
		
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT alb.id, alb.titre, alb.date_creation, alb.uti_id
				FROM AppBundle:Album alb
				JOIN AppBundle:Utilisateur uti WITH uti.id = alb.uti_id
				WHERE uti.id = :uti_id'
				)
				->setParameter('uti_id', $id);
				
				$albums = $query->getResult();
				
				return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/albums")
	 */
	
	/*public function getUtilisateurAlbumsAction($id) {
		$album = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Albums' )->find ( $id);
		/* @var $album Album */
		
	/*	if (empty ( $album )) {
			return new JsonResponse ( [
					'message' => 'Album non trouve'
			], Response::HTTP_NOT_FOUND );
		}
		
		return $album;
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/utilisateurs")
	 */
	public function postUtilisateursAction(Request $request) {
		$utilisateur = new Utilisateur ();
		$utilisateur->setNom ( $request->get ( 'uti_nom' ) )->setPrenom ( $request->get ( 'uti_prenom' ) )->setEmail ( $request->get ( 'uti_email' ) )->setMotDePass ( $request->get ( 'uti_mot_de_pass' ) );
		
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$em->persist ( $utilisateur );
		$em->flush ();
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Put("/utilisateurs/{id}")
	 */
	public function updateUtilisateurAction(Request $request) {
		$utilisateur = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->find ( $request->get ( 'id' ) );
		/* @var $utilisateur Utilisateur */
		
		if (empty ( $utilisateur )) {
			return new JsonResponse ( [ 
					'message' => 'Utilisateur non trouvé' 
			], Response::HTTP_NOT_FOUND );
		}
		
		$form = $this->createForm ( UtilisateurType::class, $utilisateur );
		
		$form->submit ( $request->request->all () );
		
		if ($form->isValid ()) {
			$em = $this->get ( 'doctrine.orm.entity_manager' );
			$em->merge ( $utilisateur );
			$em->flush ();
			return $utilisateur;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/utilisateurs/{id}")
	 */
	public function removeUtilisateurAction(Request $request) {
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$utilisateur = $em->getRepository ( 'AppBundle:Utilisateur' )->find ( $request->get ( 'id' ) );
		/* @var $utilisateur Utilisateur */
		
		if ($utilisateur) {
			$em->remove ( $utilisateur );
			$em->flush ();
		}
	}
}