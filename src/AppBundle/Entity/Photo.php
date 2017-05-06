<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="photos")
 */

class Photo
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $titre;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $date_creation;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $legende;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $image;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $alb_id;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTitre()
	{
		return $this->titre;
	}
	
	public function getDateCreation()
	{
		return $this->date_creation;
	}
	
	public function getLegende()
	{
		return $this->legende;
	}
	
	public function getImage()
	{
		return $this->image;
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
	
	public function setTitre($titre)
	{
		$this->titre = $titre;
		return $this;
	}
	
	public function setDateCreation($date_creation)
	{
		$this->date_creation = $date_creation;
		return $this;
	}
	
	public function setLegende($legende)
	{
		$this->legende = $legende;
		return $this;
	}
	
	public function setImage($image)
	{
		$this->image = $image;
		return $this;
	}
	
	public function setAlbId($alb_id)
	{
		$this->alb_id = $alb_id;
		return $this;
	}

}