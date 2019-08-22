<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\InterestCalculationInterface;

interface InterestCalculationsInterface
{

    public function addInterestCalculation( InterestCalculationInterface $interestCalculation) : void;

    public function getInterestCalculations() : array;
}