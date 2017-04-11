<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('uti_nom');
		$builder->add('uti_prenom');
		$builder->add('uti_email');
		$builder->add('uti_mot_de_pass');
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
				'data_class' => 'AppBundle\Entity\Utilisateur',
				'csrf_protection' => false
		]);
	}
}