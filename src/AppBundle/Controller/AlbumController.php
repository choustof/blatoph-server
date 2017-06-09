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
use AppBundle\Form\Type\AlbumType;
use AppBundle\Entity\Album;

class AlbumController extends Controller {

	/**
	 * @Rest\View()
	 * @Rest\Get("/albums")
	 */
	
	public function getAlbumsAction(Request $request) {
		$albums = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Album' )->findAll ();
		/* @var $albums Album[] */
		
		if (empty($albums)) {
			return new JsonResponse(['message' => 'Aucun album trouve'], Response::HTTP_NOT_FOUND);
		}
		
		return $albums;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/albums/{id}")
	 */
	
	public function getAlbumAction($id, Request $request) {
		$album = $this->get ( 'doctrine.orm.entity_manager' )->getRepository ( 'AppBundle:Album' )->find ( $id );
		/* @var $album Album */
		
		if (empty($album)) {
			return new JsonResponse(['message' => 'Album non trouve'], Response::HTTP_NOT_FOUND);
		}
		
		// Gestion de la réponse
		return $album;
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Get("/albums/{id}/photos")
	 */
	public function getAlbumPhotoAction($id, Request $request) {
		
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT ph.id, ph.titre, ph.date_creation, ph.legende, ph.path, ph.alb_id, ph.uti_id
				FROM AppBundle:Photo ph
				WHERE ph.alb_id = :alb_id'
				)
				->setParameter('alb_id', $id);
				
				$photos = $query->getResult();
				
				return $photos;
	}
	
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_CREATED)
	 * @Rest\Post("/albums")
	 */
	public function postAlbumAction(Request $request)
	{
		$album = new Album();
		
		$form = $this->createForm(AlbumType::class, $album);
		$form->submit($request->request->all());
		
		if ($form->isValid()) {
			$em = $this->get('doctrine.orm.entity_manager');
			$em->persist($album);
			$em->flush();
			return $album;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View()
	 * @Rest\Put("/albums/{id}")
	 */
	public function updateAlbumAction(Request $request) {
		$album = $this->get('doctrine.orm.entity_manager')
					  ->getRepository('AppBundle:Album')
					  ->find($request->get('id')); 
		
		/* @var $album Album */
		if (empty ( $album )) {
			return new JsonResponse ( [
					'message' => 'Album non trouvé'
			], Response::HTTP_NOT_FOUND );
		}
		
		$form = $this->createForm ( AlbumType::class, $album );
		
		$form->submit ( $request->request->all () );
		
		if ($form->isValid ()) {
			$em = $this->get ( 'doctrine.orm.entity_manager' );
			$em->merge ( $album );
			$em->flush ();
			return $album;
		} else {
			return $form;
		}
	}
	
	/**
	 * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
	 * @Rest\Delete("/albums/{id}")
	 */
	public function removeAlbumAction(Request $request) {
		$em = $this->get ( 'doctrine.orm.entity_manager' );
		$album = $em->getRepository ( 'AppBundle:Album' )->find ( $request->get ( 'id' ) );
		/* @var $album Album */
		
		if ($album) {
			$em->remove ( $album );
			$em->flush ();
		}
		
	}
	
}