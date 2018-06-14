<?php
namespace App\GameExtraBetting\Business\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserExtraBettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extrabet = $options['extrabet'];
        $teams = $options['teams'];
        $label = $options['label'];
        $type = $options['type'];

        $builder
            ->setAction('/saveextrabet/')
            ->setMethod('POST')
            ->add('text', ChoiceType::class, array(
                'label' => $label,
                'choices' => $teams,
                'data' => $extrabet ? $extrabet->getText() : null
            ))
            ->add('type', HiddenType::class, array(
                'data' => $type
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'extrabet' => null,
            'teams' => null,
            'label' => null,
            'type' => null
        ));
    }
}