<?php

namespace App\GameApi\Business\WorldCupSfgIo\Client;

use GuzzleHttp\Client as GuzzleHttpClient;


class Client implements ClientInterface
{
    private const URL = 'https://worldcup.sfg.io/';
    private const GAMES = '/matches/today';

    /**
     * @var GuzzleHttpClient
     */
    private $client;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return \App\GameApi\Persistence\DataProvider\GameResult[]
     */
    public function getGames() : array
    {
        $res = $this->getClient()->get(self::GAMES, $this->options);
        $gameInfo = (array)json_decode(
            (string)$res->getBody()->getContents(),
            true
        );

        return $this->parser->get($gameInfo);
    }

    /**
     * @return GuzzleHttpClient
     */
    private function getClient() : GuzzleHttpClient
    {
        if ($this->client === null) {
            $this->client = new GuzzleHttpClient([
                'base_uri' => self::URL
            ]);
        }
        return $this->client;
    }
}