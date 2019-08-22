<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InterestRunnerInterface;

use LendInvest\Models\Interfaces\InterestCalculationsInterface;

use LendInvest\Models\Interfaces\InvestmentsInterface;

use LendInvest\Models\InterestCalculations;

use LendInvest\Models\InterestCalculation;

use Datetime;

class InterestRunner implements InterestRunnerInterface {

    private $interestCalculationsObj;
    private $investments;
    private $startDate;
    private $endDate;

    public function __construct( InvestmentsInterface $investments , Datetime $startDate , DateTime $endDate ){
        $this->interestCalculationsObj = new InterestCalculations();
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->investments = $investments;
        $this->processInterestCalculations();
    }

    public function getInterestCalculationsObj() : InterestCalculationsInterface {
        return $this->interestCalculationsObj;
    }

    private function processInterestCalculations() : void {
        foreach( $this->investments->getInvestments() as $investment){
            $interestCalculation = new InterestCalculation( $investment , $this->startDate, $this->endDate );

            $investment->getInvestor()->addFunds( $interestCalculation->getInterest() );

            $this->interestCalculationsObj->addInterestCalculation($interestCalculation);
        }
    }
}