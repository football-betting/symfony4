<?php


namespace App\GameBetting\Persistence\DataProvider;

class ExtraFrontendResult
{
    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @param int $type
     * @param string $countryName
     */
    public function __construct(int $type, string $countryName)
    {
        $this->type = $type;
        $this->countryName = $countryName;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }
}