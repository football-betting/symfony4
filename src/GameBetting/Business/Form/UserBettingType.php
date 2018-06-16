<?php
namespace App\GameBetting\Business\Form;

use App\GameCore\Persistence\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserBettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Game $game */
        $game = $options['game'];
        $bet = $options['bet'];
        $editable = $options['editable'];

        $builder
            ->setAction('/savebet')
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
           'game' => null,
           'bet' => null,
           'editable' => null,
            'csrf_protection' => false
        ));
    }

}