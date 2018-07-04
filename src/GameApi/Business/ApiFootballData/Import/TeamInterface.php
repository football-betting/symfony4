<?php

namespace App\GameApi\Business\ApiFootballData\Import;

interface TeamInterface
{
    public function import() : void;
}