<?php
namespace App\GameBetting\Business\Form;

use App\GameCore\Persistence\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        $builder
            ->setAction('/savebet')
            ->setMethod('POST')
            ->add('firstTeamResult', IntegerType::class, array(
                'required' => true,
                'label' => $game ? $game->getTeamFirst()->getName() : null,
                'data' => $bet->getFirstTeamResult()
            ))
            ->add('secondTeamResult', IntegerType::class, array(
                'required' => true,
                'label' => $game ? $game->getTeamSecond()->getName() : null,
                'data' => $bet->getSecondTeamResult()
            ))
            ->add('saveBet', SubmitType::class, [
                'label' => 'Save'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'game' => null,
           'bet' => null
        ));
    }

}