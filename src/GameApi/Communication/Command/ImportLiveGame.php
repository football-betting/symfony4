<?php


namespace App\GameApi\Communication\Command;

use App\GameApi\Business\WorldCupSfgIo\Import\LiveGameInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLiveGame extends Command
{
    /**
     * @var LiveGameInterface
     */
    private $liveGame;

    const COMMAND_NAME = 'api:import:live-game';
    const DESCRIPTION = 'Import live games from api';

    /**
     * @param LiveGameInterface $game
     */
    public function __construct(LiveGameInterface $liveGame)
    {
        $this->liveGame = $liveGame;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->liveGame->updateLiveGames();
    }
}