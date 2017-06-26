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
use AppBundle\Form\Type\AlbumPartageType;
use AppBundle\Entity\AlbumPartage;

class AlbumPartageController extends Controller {

	/**
	 * @Rest\View()
	 * @Rest\Get("/albumPartages")
	 */
	
	public function getAlbumPartagesAction(Request $request) {
		$albumPartages = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:AlbumPartage' )->findAll ();
		/* @var $albumPartages AlbumPartage[] */
		
		if (empty($albumPartages)) {
			return new JsonResponse ( [
					'message' => 'Aucun album partage trouve'
			], Response::HTTP_NOT_FOUND );
		}
		
		return $albumPartages;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/albumPartages/{id}")
	 */
	
	public function getAlbumPartageAction($id, Request $request) {
		$albumPartage = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:AlbumPartage' )->find ( $id );
		/* @var $albumPartage AlbumPartage */
		
		if (empty($albumPartage)) {
			return new JsonResponse ( [
					'message' => 'Aucun album partage trouve'
			], Response::HTTP_NOT_FOUND );
		}
		
		// Gestion de la réponse
		return $albumPartage;
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/albumPartages")
	 */
	public function postAlbumPartagesAction(Request $request)
	{
		$albumPartage = new AlbumPartage();
		
		$form = $this->createForm(AlbumPartageType::class, $albumPartage);
		$form->submit($request->request->all());
		
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($albumPartage);
			$em->flush();
			return $albumPartage;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Put("/albumPartages/{id}")
	 */
	public function updateAlbumPartageAction(Request $request) {
		
		/* @var $albumPartage AlbumPartage */
		if (empty ( $albumPartage )) {
			return new JsonResponse ( [
					'message' => 'Aucun album partage trouve'
			], Response::HTTP_NOT_FOUND );
		}
		
		$form = $this->createForm ( AlbumPartageType::class, $albumPartage );
		
		$form->submit ( $request->request->all () );
		
		if ($form->isValid ()) {
			$em = $this->get ( 'doctrine.orm.entity_manager' );
			$em->merge ( $albumPartage );
			$em->flush ();
			return $albumPartage;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/albumPartages/{id}")
	 */
	public function removeAlbumPartageAction(Request $request) {
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$albumPartage = $em->getRepository ( 'AppBundle:AlbumPartage' )->find ( $request->get ( 'id' ) );
		/* @var $albumPartage AlbumPartage */
		
		if ($albumPartage) {
			$em->remove ( $albumPartage );
			$em->flush ();
		}
		
	}
}