<?php


namespace App\GameApi\Communication\Command;


use App\GameApi\Business\ApiFootballData\Import\TeamInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTeam extends Command
{
    /**
     * @var TeamInterface
     */
    private $team;

    const COMMAND_NAME = 'api:import:team';
    const DESCRIPTION = 'Import teams from api';

    /**
     * @param TeamInterface $team
     */
    public function __construct(TeamInterface $team)
    {
        $this->team = $team;
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
        $this->team->import();
    }
}