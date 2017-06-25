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
		
		$token = md5(uniqid());
		
		
		$utilisateurs = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->findAll ();
		/* @var $utilisateurs Utilisateur[] */
		
		if (empty ( $utilisateurs )) {
			return new JsonResponse ( [ 
					'message' => 'Aucun utilisateur trouve' 
			], Response::HTTP_NOT_FOUND );
		}
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
		
		return $utilisateur;
	}
	
	
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/albumPartages")
	 */
	public function getUtilisateurAlbumPartagesAction($id, Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		$query = $em->createQuery ( '
				SELECT alb.id, alb.titre, alb.date_creation, alb.uti_id
				FROM AppBundle:Album alb
				JOIN AppBundle:AlbumPartage alp WITH alb.id = alp.alb_id
				JOIN AppBundle:Utilisateur uti WITH uti.id = alp.uti_id
				WHERE uti.id = :uti_id' )->setParameter ( 'uti_id', $id );
		
		$albums = $query->getResult ();
		
		if (empty($albums)) {
			return new JsonResponse(['message' => 'Aucun album pargagé n\'a été trouvé'], Response::HTTP_NOT_FOUND);
		}
		
		return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/albums")
	 */
	public function getUtilisateurAlbumsAction($id, Request $request) {
		
		$em = $this->getDoctrine ()->getManager ();
		$query = $em->createQuery ('
				SELECT alb.id, alb.titre, alb.date_creation, alb.uti_id
				FROM AppBundle:Album alb
				JOIN AppBundle:Utilisateur uti WITH uti.id = alb.uti_id
				WHERE uti.id = :uti_id
				' )->setParameter ( 'uti_id', $id );
		
		$albums = $query->getResult ();
		
		if (empty($albums)) {
			return new JsonResponse(['message' => 'Aucun album trouvé'], Response::HTTP_NOT_FOUND);
		}
		
		return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{id}/amis")
	 */
	public function getUtilisateurAmisAction($id, Request $request) {
	
	
		$em = $this->getDoctrine ()->getManager ();
		$query = $em->createQuery ('
				SELECT uti.id, uti.nom, uti.prenom, uti.email
				FROM AppBundle:Utilisateur uti
				JOIN AppBundle:Ami ami WITH uti.id = ami.ami_id
				WHERE ami.uti_id = :uti_id
		' )->setParameter ( 'uti_id', $id );
		
		$albums = $query->getResult ();
		
		if (empty($albums)) {
			return new JsonResponse(['message' => 'Aucun ami trouvé'], Response::HTTP_NOT_FOUND);
		}
		
		return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/utilisateurs/{mail}/{mdp}")
	 *
	 * Methode qui disparaitra une fois que FOSUSERBUNDLE sera utilisé
	 */
	public function getUtilisateurByUsernameMdpAction($mail, $mdp, $token) {
		$em = $this->getDoctrine ()->getManager ();
		
		$token = '';
		$token = md5(uniqid());
		
		$query = $em->createQuery ( 'SELECT uti.id
				FROM AppBundle:Utilisateur uti
				WHERE uti.email = :mail
				AND uti.mot_de_pass = :mdp' )->setParameters ( array(
						'mail'=> $mail,
						'mdp' => $mdp
				)
						);
		
		$utilisateur = $query->getResult ();
		
		if (empty($utilisateur)) {
			return new JsonResponse(['message' => 'Aucun utilisateur  n\'a été trouvé'], Response::HTTP_NOT_FOUND);
		}
		
		return $utilisateur;
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/utilisateurs")
	 */
	public function postUtilisateursAction(Request $request) {
		$utilisateur = new Utilisateur ();
		
		$form = $this->createForm(UtilisateurType::class, $utilisateur);
		$form->submit($request->request->all());
		
			
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($utilisateur);
			$em->flush();
			return $utilisateur;
		} else {
			return $form;
		}
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