<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="albums")
 */

class Album
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $alb_id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $alb_titre;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $alb_date_creation;
	
	public function getId()
	{
		return $this->alb_id;
	}
	
	public function getTitre()
	{
		return $this->alb_titre;
	}
	
	public function getDateCreation()
	{
		return $this->alb_date_creation;
	}
	
	public function setId($alb_id)
	{
		$this->alb_id = $alb_id;
		return $this;
	}
	
	public function setTitre($alb_titre)
	{
		$this->alb_titre = $alb_titre;
		return this;
	}
	
	public function setDateCreation($alb_date_creation)
	{
		$this->alb_date_creation = $alb_date_creation;
		return $this;
	}

}