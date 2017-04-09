<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Utilisateur;

class UtilisateurController extends Controller {
	/**
	 * @Route("/utilisateurs", name="utilisateurs_list")
	 * 
	 * @method ({"GET"})
	 */
	public function getUtilisateursAction(Request $request) {
		$utilisateurs = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->findAll ();
		/* @var $utilisateurs Utilisateur[] */
		
		$formatted = [ ];
		foreach ( $utilisateurs as $utilisateur ) {
			$formatted [] = [ 
					'uti_id' => $utilisateur->getId (),
					'uti_nom' => $utilisateur->getNom (),
					'uti_prenom' => $utilisateur->getPrenom (),
					'uti_email' => $utilisateur->getEmail (),
					'uti_mot_de_pass' => $utilisateur->getMotDePass () 
			];
		}
		
		return new JsonResponse ( $formatted );
	}
	
	/**
	 * @Route("/utilisateurs/{uti_id}", name="utilisateurs_one")
	 * 
	 * @method ({"GET"})
	 */
	public function getUtilisateurAction(Request $request) {
		$utilisateur = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Utilisateur' )->find ( $request->get ( 'uti_id' ) );
		/* @var $utilisateur Utilisateur */
		
		if (empty($utilisateur)) {
			return new JsonResponse(['message' => 'Utilisateur non trouve'], Response::HTTP_NOT_FOUND);
		}
		
		$formatted = [ 
				'uti_id' => $utilisateur->getId (),
				'uti_nom' => $utilisateur->getNom (),
				'uti_prenom' => $utilisateur->getPrenom (),
				'uti_email' => $utilisateur->getEmail (),
				'uti_mot_de_pass' => $utilisateur->getMotDePass () 
		];
		
		return new JsonResponse ( $formatted );
	}
}