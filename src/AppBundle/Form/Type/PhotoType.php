<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PhotoType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('titre');
		$builder->add('date_creation');
		$builder->add('legende');
		$builder->add('image');
		$builder->add('alb_id');
		$builder->add('uti_id');
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
				'data_class' => 'AppBundle\Entity\Photo',
				'csrf_protection' => false
		]);
	}
	
	public function getName(){
		return 'appbundle_form_phototype';
	}
}