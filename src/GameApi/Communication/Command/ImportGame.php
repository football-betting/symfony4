<?php


namespace App\GameApi\Communication\Command;


use App\GameApi\Business\ApiFootballData\Import\GameInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportGame extends Command
{
    /**
     * @var GameInterface
     */
    private $game;

    const COMMAND_NAME = 'api:import:game';
    const DESCRIPTION = 'Import games from api';

    /**
     * @param GameInterface $game
     */
    public function __construct(GameInterface $game)
    {
        $this->game = $game;
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
        $this->game->import();
    }
}