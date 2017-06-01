<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File as File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\DomCrawler\Image;

/**
 * @ORM\Entity()
 * @ORM\Table(name="photos")
 * @Vich\Uploadable
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
	 * 
	 */
	protected $legende;
	
	 /**
     * @Vich\UploadableField(mapping="image", fileNameProperty="id")
     *
     * @var File $image
     */
	protected $image;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $alb_id;
	
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
	
	public function setLegende($legende)
	{
		$this->legende = $legende;
		return $this;
	}

	/**
	 * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
	 *
	 */
	public function setImage(File $image)
	{
		$this->image = $image;
		return $this;
	}
	
	public function setAlbId($alb_id)
	{
		$this->alb_id = $alb_id;
		return $this;
	}
	
	public function setUtiId($uti_id)
	{
		$this->uti_id = $uti_id;
		return $this;
	}

}