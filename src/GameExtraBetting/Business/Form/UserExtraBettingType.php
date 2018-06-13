<?php
namespace App\GameExtraBetting\Business\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserExtraBettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extrabet = $options['extrabet'];
        $teams = $options['teams'];

        $builder
            ->setAction('/saveextrabet')
            ->setMethod('POST')
            ->add('firstTeamResult', IntegerType::class, array(
                'required' => true,
                'label' => $game ? $game->getTeamFirst()->getName() : null,
                'data' => $bet ? $bet->getFirstTeamResult() : null,
                'disabled' => $editable
            ))
            ->add('secondTeamResult', IntegerType::class, array(
                'required' => true,
                'label' => $game ? $game->getTeamSecond()->getName() : null,
                'data' => $bet ? $bet->getSecondTeamResult() : null,
                'disabled' => $editable
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