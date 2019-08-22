<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\TrancheInterface;
use LendInvest\Models\Interfaces\LoanInterface;

use DateTime;

class Loan implements LoanInterface
{

    private $startDate;
    private $endDate;
    private $tranches = array();

    public function __construct( datetime $startDate , datetime $endDate , array $tranches )
    {
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);

        foreach($tranches as $tranche){
            $this->addTranche($tranche);
        }
    }

    public function addTranche( TrancheInterface $tranche ) : void
    {

        array_push($this->tranches, $tranche);
    }

    public function getTranches() : array
    {
        return $this->tranches;
    }

    private function setStartDate( datetime $startDate) : void
    {
        $this->startDate = $startDate;
    }

    public function getStartDate() : datetime
    {
        return $this->startDate;
    }

    public function getEndDate() : datetime
    {
        return $this->endDate;
    }

    private function setEndDate( datetime $endDate) : void
    {
        $this->endDate = $endDate;
    }
}