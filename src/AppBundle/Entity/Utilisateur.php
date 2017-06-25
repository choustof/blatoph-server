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
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $nom;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $prenom;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $mot_de_pass;
	
	/**
     * @ORM\Column(type="string", nullable=true)
	 */
	protected $albumCourant_id;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $token;
	
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getNom()
	{
		return $this->nom;
	}
	
	public function getPrenom()
	{
		return $this->prenom;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getMotDePass()
	{
		return $this->mot_de_pass;
	}
	
	public function getToken()
	{
		return $this->token;
	}
	
	public function getAlbumCourantId(){
		return $this->albumCourant_id;
	}
	
	public function setAlbumCourantId($albumCourant_id){
		$this->albumCourant_id=$albumCourant_id;
		return $this;
	}
	
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}
	
	public function setNom($nom)
	{
		$this->nom = $nom;
		return $this;
	}
	
	public function setPrenom($prenom)
	{
		$this->prenom = $prenom;
		return $this;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
		return $this;
	}
	
	public function setMotDePass($mot_de_pass)
	{
		$this->mot_de_pass = $mot_de_pass;
		return $this;
	}
}