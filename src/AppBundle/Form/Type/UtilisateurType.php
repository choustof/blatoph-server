<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom');
		$builder->add('prenom');
		$builder->add('email');
		$builder->add('mot_de_pass');
		$builder->add('albumCourant_id');
		$builder->add('token');
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
				'data_class' => 'AppBundle\Entity\Utilisateur',
				'csrf_protection' => false
		]);
	}
}