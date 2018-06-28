<?php


namespace App\GameApi\Business\ApiFootballData;


use GuzzleHttp\Client as GuzzleHttpClient;

class Client implements ClientInterface
{
    private const TEAMS = '/v1/competitions/467/teams';
    private const GAMES = '/v1/competitions/467/fixtures';

    /**
     * @var GuzzleHttpClient
     */
    private $client;

    /**
     * @var array
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

    /**
     * @return array
     */
    public function getTeams() : array
    {
        $res = $this->getClient()->get(self::TEAMS, $this->options);
        return (array)json_decode(
            (string)$res->getBody()->getContents(),
            true
        );
    }

    /**
     * @return array
     */
    public function getGames() : array
    {
        $res = $this->getClient()->get(self::GAMES, $this->options);
        return (array)json_decode(
            (string)$res->getBody()->getContents(),
            true
        );
    }

    /**
     * @return GuzzleHttpClient
     */
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