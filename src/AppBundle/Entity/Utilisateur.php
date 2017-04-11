<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="utilisateurs")
 */

class Utilisateur
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $uti_id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $uti_nom;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $uti_prenom;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $uti_email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $uti_mot_de_pass;
	
	public function getId()
	{
		return $this->uti_id;
	}
	
	public function getNom()
	{
		return $this->uti_nom;
	}
	
	public function getPrenom()
	{
		return $this->uti_prenom;
	}
	
	public function getEmail()
	{
		return $this->uti_email;
	}
	
	public function getMotDePass()
	{
		return $this->uti_mot_de_pass;
	}
	
	public function setId($uti_id)
	{
		$this->uti_id = $uti_id;
		return $this;
	}
	
	public function setNom($uti_nom)
	{
		$this->uti_nom = $uti_nom;
		return $this;
	}
	
	public function setPrenom($uti_prenom)
	{
		$this->uti_prenom = $uti_prenom;
		return $this;
	}
	
	public function setEmail($uti_email)
	{
		$this->uti_email = $uti_email;
		return $this;
	}
	
	public function setMotDePass($uti_mot_de_pass)
	{
		$this->uti_mot_de_pass = $uti_mot_de_pass;
		return $this;
	}
}