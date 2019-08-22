<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InterestCalculationsInterface;
use LendInvest\Models\Interfaces\InterestCalculationInterface;

class InterestCalculations implements InterestCalculationsInterface
{

    private $interestCalculations = array();

    public function addInterestCalculation( InterestCalculationInterface $interestCalculation) : void
    {
        array_push($this->interestCalculations, $interestCalculation);
    }

    public function getInterestCalculations() : array
    {
        return $this->interestCalculations;
    }
}