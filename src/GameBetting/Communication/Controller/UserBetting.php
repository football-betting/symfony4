<?php

namespace App\GameBetting\Communication\Controller;


use App\GameBetting\Business\Form\UserBettingType;
use App\GameBetting\Business\Games\UserFutureGamesInterface;
use App\GameBetting\Business\Games\UserPastGamesInterface;
use App\GameBetting\Persistence\DataProvider\ExtraFrontendResult;
use App\GameBetting\Persistence\Entity\UserBetting as UserBettingEntity;
use App\GameCore\Persistence\Entity\Game;
use App\GameCore\Persistence\Entity\Team;
use App\GameCore\Persistence\Repository\GameRepository;
use App\GameExtraBetting\Persistence\Entity\UserExtraBetting;
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
                'pastGamesForm' => \array_reverse(\array_slice($pastGamesForm, -6))
            ]
        );
    }

    /**
     * @Route("/active-games/", name="active-games")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getActiveGames()
    {
        $activeGames = $this->userPastGames->getActiveGames($this->getUser());

        return $this->render(
            'gamebetting/betting/active_games.html.twig',
            [
                'activeGames' => $activeGames
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
        $user = $this->getUser();
        $pastGamesForm = $this->userPastGames->get($user);

        return $this->render(
            'gamebetting/betting/past_games.html.twig',
            [
                'pastGamesForm' => $pastGamesForm,
                'username' => false,
                'extraInfo' => $this->extraInfo($user)
            ]
        );
    }

    /**
     * toDo Refactor this
     * @Route("/past-game-detail/{gameId}", name="past_game_detail")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pastGameDetail(int $gameId)
    {
        $users = $this->getDoctrine()->getRepository(User::class)
            ->findBy([], ['username' => 'ASC']);

        $teamFirstName = '';
        $teamSecondName = '';
        $gameInfo2users = [];
        foreach ($users as $user) {
            $pastGamesForm = $this->userPastGames->getOnePastGame($user, $gameId);
            if (!empty($pastGamesForm)) {
                $teamFirstName = current($pastGamesForm)->getFirstTeamName();
                $teamSecondName = current($pastGamesForm)->getSecondTeamName();

                $gameInfo2users[$user->getUsername()] = current($pastGamesForm);
            }

        }

        return $this->render(
            'gamebetting/betting/past_game_detail.html.twig',
            [
                'gameInfo2users' => $gameInfo2users,
                'teamFirstName' => $teamFirstName,
                'teamSecondName' => $teamSecondName,
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
        $extraInfo = [];
        if ($user instanceof User) {
            $pastGamesForm = $this->userPastGames->get($user);
            $username = $user->getUsername();
            $extraInfo = $this->extraInfo($user);
        }



        return $this->render(
            'gamebetting/betting/past_games.html.twig',
            [
                'pastGamesForm' => $pastGamesForm,
                'username' => $username,
                'extraInfo' => $extraInfo,
            ]
        );

    }

    public function getNextGames(int $numberOfGames)
    {
        $gameBetResult = \array_slice($this->userFutureGames->get($this->getUser()), 0, $numberOfGames);

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
        $params = (array)$request->get('user_betting');
        $userBetting = new UserBettingEntity();
        $form = $this->createForm(UserBettingType::class, $userBetting);
        $form->handleRequest($request);

        if ($this->isSaveFormInValid($form, $params) === true) {
            return $this->json(['status' => false]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $userBetting = $entityManager->getRepository(UserBettingEntity::class)
            ->findByGameIdAndUserId($params['gameId'], $this->getUser()->getId());
        if (!$userBetting instanceof UserBettingEntity) {
            $userBetting = new UserBettingEntity();
            $game = $entityManager->getRepository(Game::class)
                ->find($params['gameId']);
            $userBetting->setGame($game);
            $userBetting->setUser($this->getUser());
        }


        $userBetting->setFirstTeamResult((int)$params['firstTeamResult']);
        $userBetting->setSecondTeamResult((int)$params['secondTeamResult']);

        if ($userBetting->getGame()->getDate()->getTimestamp() < time()) {
            return $this->json(['status' => false]);
        }

        $entityManager->persist($userBetting);
        $entityManager->flush();

        return $this->json(['status' => true]);
    }

    /**
     * @param $form
     * @param array $params
     * @return bool
     */
    private function isSaveFormInValid($form, array $params): bool
    {
        $isSymfonyFormInValid = (!$form->isSubmitted() && !$form->isValid());
        $isFirstTeamResultNotValid = (!isset($params['firstTeamResult']) || $params['firstTeamResult'] < 0);
        $isSecondTeamResultNotValid = (!isset($params['secondTeamResult']) || $params['secondTeamResult'] < 0);

        return $isSymfonyFormInValid || $isFirstTeamResultNotValid || $isSecondTeamResultNotValid;
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

    /**
     * @param $user
     * @return array
     */
    protected function extraInfo($user): array
    {
        $userExterBettings = $this->getDoctrine()->getRepository(UserExtraBetting::class)->getByUser($user);
        $extraInfo = [];
        foreach ($userExterBettings as $userExterBetting) {
            $team = $this->getDoctrine()->getRepository(Team::class)->find((int)$userExterBetting->getText());
            $extraInfo[] = new ExtraFrontendResult(
                $userExterBetting->getType(),
                $team->getName()
            );
        }
        return $extraInfo;
    }
}