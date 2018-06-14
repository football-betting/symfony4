<?php

namespace App\GameBetting\Communication\Controller;


use App\GameBetting\Business\Form\UserBettingType;
use App\GameBetting\Business\Games\UserFutureGamesInterface;
use App\GameBetting\Business\Games\UserPastGamesInterface;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserBetting extends Controller
{
    /**
     * @var UserFutureGamesInterface
     */
    private $userFutureGames;

    /**
     * @var UserPastGamesInterface
     */
    private $userPastGames;

    /**
     * @param UserFutureGamesInterface $userFutureGames
     * @param UserPastGamesInterface $userPastGames
     */
    public function __construct(UserFutureGamesInterface $userFutureGames, UserPastGamesInterface $userPastGames)
    {
        $this->userFutureGames = $userFutureGames;
        $this->userPastGames = $userPastGames;
    }

    /**
     * @Route("/gamebet/", name="game_bet_list")
     */
    public function list()
    {
        $futureGamesFormBuilder = $this->getFutureGamesFormBuilder();
        $pastGamesForm = $this->userPastGames->get($this->getUser());

        return $this->render(
            'gamebetting/betting/betting.html.twig',
            [
                'futureGamesForm' => $futureGamesFormBuilder,
                'pastGamesForm'   => $pastGamesForm
            ]
        );
    }

    /**
     * @Route("/savebet", name="save_bet")
     * @Method({"POST"})
     */
    public function saveBet(Request $request)
    {
        $params = $request->get('user_betting');
        $userBetting = new UserBettingEntity();
        $form = $this->createForm(UserBettingType::class, $userBetting);
        $form->handleRequest($request);
        if (!$form->isSubmitted() && !$form->isValid()) {
            return $this->json(['status' => false]);
        }
        if(!isset($params['firstTeamResult'])  || $params['firstTeamResult'] < 0) {
            return $this->json(['status' => false]);
        }
        if(!isset($params['secondTeamResult'])  || $params['secondTeamResult'] < 0) {
            return $this->json(['status' => false]);
        }
        
        $entityManager = $this->getDoctrine()->getManager();

        $userBetting = $entityManager->getRepository(UserBettingEntity::class)
                                     ->findByGameIdAndUserId($params['gameId'], $this->getUser()->getId())
        ;
        if (!$userBetting instanceof UserBettingEntity) {
            $userBetting = new UserBettingEntity();
            $game = $entityManager->getRepository(Game::class)
                                  ->find($params['gameId']);
            $userBetting->setGame($game);
            $userBetting->setUser($this->getUser());
        }


        $userBetting->setFirstTeamResult($params['firstTeamResult']);
        $userBetting->setSecondTeamResult($params['secondTeamResult']);

        if($userBetting->getGame()->getDate()->getTimestamp() < time() ) {
            return $this->json(['status' => false]);
        }

        $entityManager->persist($userBetting);
        $entityManager->flush();

        return $this->json(['status' => true]);
    }

    /**
     * @return array
     */
    private function getFutureGamesFormBuilder(): array
    {
        $userFurureGames = $this->userFutureGames->get(
            $this->getUser()
        );
        $gamesFormBuilder = [];
        foreach ($userFurureGames as $gameId => $futureGameInfo) {
            $gamesFormBuilder[$gameId] = $this->createForm(
                UserBettingType::class, null, $futureGameInfo
            )->createView();
        }
        return $gamesFormBuilder;
    }
}