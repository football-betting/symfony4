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


    public function getTeams()
    {
        $res = $this->getClient()->request('GET', self::TEAMS);
        return json_decode(
            (string)$res->getBody()->getContents(),
            true
        );
    }

    public function getGames()
    {
        $res = $this->getClient()->request('GET', self::GAMES);
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