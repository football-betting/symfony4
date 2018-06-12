<?php

namespace App\GameExtraBetting\Communication\Controller;


use App\GameBetting\Business\Form\UserBettingType;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserExtraBetting extends Controller
{
    /**
     * @Route("/gamebetextra/", name="game_bet_extra")
     */
    public function index()
    {


        return $this->render(
            'gameextrabetting/user_extra_betting/index.html.twig'
        );
    }
}