<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\InterestCalculationInterface;
use LendInvest\Models\Interfaces\InvestmentInterface;

interface InterestCalculationInterface
{

    public function getInvestment() : InvestmentInterface;

    public function getInterest() : float;
}