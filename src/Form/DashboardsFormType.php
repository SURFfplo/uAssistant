<?php
	
namespace App\Form;

use App\Entity\Dashboards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DashboardsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $builder
	    ->add('name', TextType::class, ['label' => 'Naam'])
	    ->add('description', TextareaType::class, ['label' => 'Beschrijving'])
	    ->add('hidden', ChoiceType::class, [
	    	'label' => 'Verborgen',
	    	'multiple' => false,
	    	'choices'  => [
		        'Nee' => false,
		        'Ja' => true,
			],
			'help' => 'Een verborgen dashboard is niet zichtbaar in het hoofdmenu.',
            'attr' => [
                'class' => 'select2'
            ],
	    	])
	    ->add('public', ChoiceType::class, [
	    	'label' => 'Publiek',
	    	'multiple' => false,
	    	'choices'  => [
		        'Nee' => false,
		        'Ja' => true,
			],
			'help' => 'Dit dashboard is publiek zichtbaar voor andere gebruikers?',
            'attr' => [
                'class' => 'select2'
            ],
	    	])
	    ->add('save', SubmitType::class, [
		    'attr' => [
				'class' => 'btn-dark'
			],
	    ]);
	    
	}

	public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dashboards::class
        ]);
    }
}