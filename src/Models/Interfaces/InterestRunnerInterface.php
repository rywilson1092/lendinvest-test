<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\InterestCalculationsInterface;

interface InterestRunnerInterface
{
    public function getInterestCalculationsObj() : InterestCalculationsInterface;
}