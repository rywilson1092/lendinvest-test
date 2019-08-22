<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\TrancheInterface;

use Exception;

class Tranche implements TrancheInterface
{

    private $maximumInvestment;
    private $currentInvestment = 0;
    private $interestRate;

    public function __construct( float $maximumInvestment , float $interestRate )
    {
        $this->setMaximumInvestment($maximumInvestment);
        $this->setInterestRate($interestRate);
    }

    public function getMaximumInvestment() : float
    {
        return $this->maximumInvestment;
    }

    public function getCurrentInvestment() : float
    {
        return $this->currentInvestment;
    }

    public function getRemainingInvestment() : float
    {
        return  $this->maximumInvestment - $this->currentInvestment;
    }

    public function getInterestRate() : float
    {
        return $this->interestRate;
    }

    public function makeInvestment( float $amount ) : void
    {

        if($this->getRemainingInvestment() < $amount ) {
            throw new exception("Not enough remaining to invest");
        }

        $this->currentInvestment += $amount;
    }

    private function setMaximumInvestment( float $maximumInvestment ) : void
    {
        $this->maximumInvestment = $maximumInvestment;
    }

    private function setInterestRate( float $interestRate ) : void
    {
        $this->interestRate = $interestRate;
    }
}