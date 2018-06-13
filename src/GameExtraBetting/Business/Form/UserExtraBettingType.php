<?php
namespace App\GameExtraBetting\Business\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserExtraBettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extrabet = $options['extrabet'];
        $teams = $options['teams'];

        $builder
            ->setAction('/saveextrabet/')
            ->setMethod('POST')
            ->add('text', ChoiceType::class, array(
                'label' => 'Mannschaften',
                'choices' => $teams,
                'data' => $extrabet ? $extrabet->getText() : null
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'extrabet' => null,
            'teams' => null,
        ));
    }
}