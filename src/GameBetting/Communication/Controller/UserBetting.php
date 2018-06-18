<?php

namespace App\GameBetting\Communication\Controller;


use App\GameBetting\Business\Form\UserBettingType;
use App\GameBetting\Business\Games\UserFutureGamesInterface;
use App\GameBetting\Business\Games\UserPastGamesInterface;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use App\GameCore\Persistence\Repository\GameRepository;
use App\User\Persistence\Entity\User;
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
     * @TODO template struktur überarbeiten und eigene actions machen
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
                'pastGamesForm'   => \array_slice($pastGamesForm, -10)
            ]
        );
    }

    /**
     * @Route("/all-upcomming-games", name="all_upcomming_games")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allUpcommingGames()
    {
        $futureGamesFormBuilder = $this->getFutureGamesFormBuilder();

        return $this->render(
            'gamebetting/betting/all_games.html.twig',
            [
                'futureGamesForm' => $futureGamesFormBuilder
            ]
        );
    }


    /**
     * @Route("/all-past-games", name="all_past_games")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allPastGames()
    {
        $pastGamesForm = $this->userPastGames->get($this->getUser());

        return $this->render(
            'gamebetting/betting/past_games.html.twig',
            [
                'pastGamesForm'   => $pastGamesForm,
                'username' => false
            ]
        );
    }

    /**
     * @Route("/all-past-games-by-user/{userId}", name="game_past_games_by_users")
     */
    public function allPastGameByUserId(int $userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)
                            ->findOneBy(['id' => $userId]);
        $pastGamesForm = [];
        $username = '';
        if($user instanceof User) {
            $pastGamesForm = $this->userPastGames->get($user);
            $username = $user->getUsername();
        }

        return $this->render(
            'gamebetting/betting/past_games.html.twig',
            [
                'pastGamesForm'   => $pastGamesForm,
                'username'   => $username
            ]
        );

    }

    public function getNextGames(int $numberOfGames)
    {
        $gameBetResult = \array_slice($this->userFutureGames->get($this->getUser()),0,$numberOfGames);

        return $this->render(
            'dashboard/next_games.html.twig',
            [
                'gameBetResult' => $gameBetResult
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


        $userBetting->setFirstTeamResult((int)$params['firstTeamResult']);
        $userBetting->setSecondTeamResult((int)$params['secondTeamResult']);

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