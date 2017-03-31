<?php
namespace AppBundle\Entity;

class Utilisateur
{
	public $nom;
	public $prenom;	
	public $email;
	public $mot_de_pass;
	
	public function __construct($nom, $prenom, $email, $mot_de_pass)
	{
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->email = $email;
		$this->mot_de_pass = $mot_de_pass;
	}
}
?>