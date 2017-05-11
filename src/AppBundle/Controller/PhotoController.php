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
use AppBundle\Form\Type\PhotoType;
use AppBundle\Entity\Photo;

class PhotoController extends Controller {

	/**
	 * @Rest\View()
	 * @Rest\Get("/photos")
	 */
	
	public function getPhotoAction(Request $request) {
		$photos = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Photo' )->findAll ();
		/* @var $Photos Photo[] */
		
		if (empty($photos)) {
			return new JsonResponse(['message' => 'Aucune photo trouvee'], Response::HTTP_NOT_FOUND);
		}
		
		return $photos;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/photos/{id}")
	 */
	
	public function getPhotoAction($id, Request $request) {
		$photo = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Photo' )->find ( $id );
		/* @var $photo Photo */
		
		if (empty($photo)) {
			return new JsonResponse(['message' => 'Photo non trouvee'], Response::HTTP_NOT_FOUND);
		}
		
		// Gestion de la réponse
		return $photo;
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/photos")
	 */
	public function postPhotoAction(Request $request)
	{
		$photo = new Photo();
		
		$form = $this->createForm(PhotoType::class, $photo);
		$form->submit($request->request->all());
		
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($photo);
			$em->flush();
			return $photo;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Put("/photos/{id}")
	 */
	public function updatePhotoAction(Request $request) {
		
		/* @var $photo Photo */
		if (empty ( $photo )) {
			return new JsonResponse ( [
					'message' => 'Photo non trouvée'
			], Response::HTTP_NOT_FOUND );
		}
		
		$form = $this->createForm ( PhotoType::class, $photo );
		
		$form->submit ( $request->request->all () );
		
		if ($form->isValid ()) {
			$em = $this->get ( 'doctrine.orm.entity_manager' );
			$em->merge ( $photo );
			$em->flush ();
			return $photo;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/photo/{id}")
	 */
	public function removePhotoAction(Request $request) {
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$album = $em->getRepository ( 'AppBundle:Photo' )->find ( $request->get ( 'id' ) );
		/* @var $photo Photo */
		
		if ($photo) {
			$em->remove ( $photo );
			$em->flush ();
		}
	}
}