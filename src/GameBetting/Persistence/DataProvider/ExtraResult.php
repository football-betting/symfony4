<?php


namespace App\GameBetting\Persistence\DataProvider;

class ExtraResult
{
    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $countryId;

    /**
     * @param int $type
     * @param int $countryId
     */
    public function __construct(int $type, int $countryId)
    {
        $this->type = $type;
        $this->countryId = $countryId;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getCountryId(): int
    {
        return $this->countryId;
    }
}