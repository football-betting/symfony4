<?php

namespace App\GameBetting\Communication\Controller;


use App\GameBetting\Business\Form\UserBettingType;
use App\GameBetting\Persistence\DataProvider\GamePastBetting;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserBetting extends Controller
{
    /**
     * @Route("/gamebet/", name="game_bet_list")
     */
    public function list()
    {


        $futureGames = $this->getDoctrine()
                            ->getRepository(Game::class)
                            ->findFutureGames()
        ;
        $futureGamesFormBuilder = $this->getFormList($futureGames);


        $pastGames = $this->getDoctrine()
                          ->getRepository(Game::class)
                          ->findPastGames()
        ;

        $user = $this->getUser();

        $userBets = $this->getDoctrine()
                         ->getRepository(UserBettingEntity::class)
                         ->findUserBettingByUserId($user, $pastGames)
        ;

        $pastGamesForm = [];
        /** @var UserBettingEntity[] $gameId2UserBets */
        $gameId2UserBets = [];
        /** @var UserBettingEntity $userBet */
        foreach ($userBets as $userBet) {
            $gameId2UserBets[$userBet->getGame()->getId()] = $userBet;
        }
        /** @var Game[] $pastGames */

//        string $firstTeamName,
//        string $secondTeamName,
//        \DateTime $gameDate,
//        int $firstTeamResult,
//        int $secondTeamResult,
//        ?int $firstTeamUserResult,
//        ?int $secondTeamUserResult

        foreach ($pastGames as $pastGame) {

            $firstTeamUserResult = null;
            $secondTeamUserResult = null;
            if (isset($gameId2UserBets[$pastGame->getId()])) {
                $firstTeamUserResult = $gameId2UserBets[$pastGame->getId()]->getFirstTeamResult();
                $secondTeamUserResult = $gameId2UserBets[$pastGame->getId()]->getSecondTeamResult();
            }

            $pastGamesForm[] = new GamePastBetting(
                $pastGame->getTeamFirst()->getName(),
                $pastGame->getTeamSecond()->getName(),
                $pastGame->getDate(),
                (int)$pastGame->getFirstTeamResult(),
                (int)$pastGame->getSecondTeamResult(),
                $firstTeamUserResult,
                $secondTeamUserResult
            );
        }

        return $this->render(
            'gamebetting/betting/betting.html.twig',
            [
                'futureGamesForm' => $futureGamesFormBuilder,
                'pastGamesForm'   => $pastGamesForm
            ]
        );
    }


    /**
     * @Route("/gamebet/{gameId}", name="game_bet")
     */
    public function index($gameId)
    {
        $game = $this->getDoctrine()
                     ->getRepository(Game::class)
                     ->find($gameId)
        ;

        if (!$game) {
            return $this->redirectToRoute('replace_with_some_route');
        }

        $form = $this->createForm(UserBettingType::class, null, ['game' => $game]);

        return $this->render(
            'gamebetting/betting/betting.html.twig',
            array('form' => $form->createView())
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
            return $this->json(array('status' => false));
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

        $entityManager->persist($userBetting);
        $entityManager->flush();

        return $this->json(array('status' => true));
    }

    private function getFormList($games, $editable = false): array
    {
        $user = $this->getUser();

        $userBets = $this->getDoctrine()
                         ->getRepository(UserBettingEntity::class)
                         ->findUserBettingByUserId($user, $games)
        ;

        /** @var UserBettingEntity[] $gameId2UserBets */
        $gameId2UserBets = [];
        /** @var UserBettingEntity $userBet */
        foreach ($userBets as $userBet) {
            $gameId2UserBets[$userBet->getGame()->getId()] = $userBet;
        }
        $gamesFormBuilder = [];
        /** @var Game $game */
        foreach ($games as $game) {
            $bet = new \App\GameBetting\Persistence\DataProvider\UserBetting();
            if (isset($gameId2UserBets[$game->getId()])) {
                $bet->setSecondTeamResult(
                    $gameId2UserBets[$game->getId()]->getSecondTeamResult()
                );
                $bet->setFirstTeamResult(
                    $gameId2UserBets[$game->getId()]->getFirstTeamResult()
                );
            }

            $gamesFormBuilder[$game->getId()] = $this->createForm(
                UserBettingType::class, null, ['game' => $game, 'bet' => $bet, 'editable' => $editable]
            )->createView()
            ;
        }

        return $gamesFormBuilder;
    }
}