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
use AppBundle\Form\Type\AmiType;
use AppBundle\Entity\Ami;

class AmiController extends Controller {

	/**
	 * @Rest\View()
	 * @Rest\Get("/ami")
	 */
	
	public function getAmiAction(Request $request) {
		
		$logger = $this->get('logger');
		$logger->info('Passage dns amis');
		$logger->error('');
		
		$logger->critical('Passage', array(
				// include extra "context" info in your logs
				'cause' => 'test',
		));
		
		$amis = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Ami' )->findAll ();
		/* @var $Amis Ami[] */
		
		if (empty($amis)) {
			return new JsonResponse(['message' => 'Aucun ami trouve'], Response::HTTP_NOT_FOUND);
		}
		
		return $amis;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/amis/{id}")
	 */
	
	public function getAmiAction($id, Request $request) {
		$ami = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Ami' )->find ( $id );
		/* @var $ami Ami */
		
		if (empty($ami)) {
			return new JsonResponse(['message' => 'Ami non trouve'], Response::HTTP_NOT_FOUND);
		}
		
		// Gestion de la réponse
		return $ami;
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/amis")
	 */
	public function postAmisAction(Request $request)
	{
		$ami = new Ami();
		
		$form = $this->createForm(AmiType::class, $ami);
		$form->submit($request->request->all());
		
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($ami);
			$em->flush();
			return $ami;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Put("/amis/{id}")
	 */
	public function updateAmiAction(Request $request) {
		
		/* @var $ami Ami */
		if (empty ( $ami )) {
			return new JsonResponse ( [
					'message' => 'Ami non trouvé'
			], Response::HTTP_NOT_FOUND );
		}
		
		$form = $this->createForm ( AmiType::class, $ami );
		
		$form->submit ( $request->request->all () );
		
		if ($form->isValid ()) {
			$em = $this->get ( 'doctrine.orm.entity_manager' );
			$em->merge ( $ami );
			$em->flush ();
			return $ami;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/amis/{id}")
	 */
	public function removeAmiAction(Request $request) {
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$ami = $em->getRepository ( 'AppBundle:Ami' )->find ( $request->get ( 'id' ) );
		/* @var $ami Ami */
		
		if ($ami) {
			$em->remove ( $ami );
			$em->flush ();
		}
	}
}