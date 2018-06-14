<?php


namespace App\GameApi\Business\ApiFootballData;


use GuzzleHttp\Client as GuzzleHttpClient;

class Client implements ClientInterface
{
    private const TEAMS = '/v1/competitions/467/teams';
    private const GAMES = '/v1/competitions/467/fixtures';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $options = [];

    /**
     */
    public function __construct()
    {
        if (null !== getenv('API_FOOTBALL_DATA')) {
            $this->options = [
                'headers' => [
                    'X-Auth-Token' => getenv('API_FOOTBALL_DATA')
                ]
            ];
        }
    }


    public function getTeams()
    {
        $res = $this->getClient()->get(self::TEAMS, $this->options);
        return json_decode(
            (string)$res->getBody()->getContents(),
            true
        );
    }

    public function getGames()
    {
        $res = $this->getClient()->get(self::GAMES, $this->options);
        return json_decode(
            (string)$res->getBody()->getContents(),
            true
        );
    }

    private function getClient()
    {
        if ($this->client === null) {
            $this->client = new GuzzleHttpClient([
                'base_uri' => 'http://api.football-data.org/'
            ]);
        }
        return $this->client;
    }
}