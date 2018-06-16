<?php


namespace App\GameBetting\Business\GamePoints;


interface Config
{
    public const WIN_EXACT = 3;
    public const WIN_SCORE_DIFF = 2;
    public const WIN_TEAM = 1;
    public const NO_WIN_TEAM = 0;
}