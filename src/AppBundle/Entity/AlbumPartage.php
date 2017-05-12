<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="album_partages")
 */

class AlbumPartage
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $uti_id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $alb_id;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getUtiId()
	{
		return $this->uti_id;
	}
	
	public function getAlbId()
	{
		return $this->alb_id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function setUtiId($uti_id)
	{
		$this->uti_id = $uti_id;
		return $this;
	}
	
	public function setAlbId($alb_id)
	{
		$this->alb_id = $alb_id;
		return $this;
	}
}