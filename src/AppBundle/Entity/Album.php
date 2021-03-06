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
	 * @ORM\Column(type="integer")
	 */
	protected $uti_id;
	
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
	
	public function getUtiId()
	{
		return $this->uti_id;
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
	
	public function setUtiId($uti_id)
	{
		$this->uti_id = $uti_id;
		return $this;
	}

}