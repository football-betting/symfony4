<?php


namespace App\Tests\Integration\Helper;


interface Config
{
    const TEAM_PAST_ONE = 'TeamPastOne';
    const TEAM_PAST_TWO = 'TeamPastTwo';
    const TEAM_PAST_THREE = 'TeamPastThree';

    const TEAM_FUTURE_ONE = 'TeamFutureOne';
    const TEAM_FUTURE_TWO = 'TeamFutureTwo';
    const TEAM_FUTURE_THREE = 'TeamFutureThree';

    const USER_EMAIL = 'unit@app.com';
    const USER_NAME = 'unit-app';
    const USER_PASS = 'unitTestApp!';

    const USER_EMAIL_TWO = 'unit-two@app.com';
    const USER_NAME_TWO = 'unit-two-app';
    const USER_PASS_TWO = 'unitTwoTestApp!';
}