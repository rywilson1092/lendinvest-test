<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InvestmentInterface;
use LendInvest\Models\Interfaces\LoanInterface;
use LendInvest\Models\Interfaces\TrancheInterface;
use LendInvest\Models\Interfaces\InvestorInterface;

use DateTime;

class Investment implements InvestmentInterface
{

    private $loan;
    private $tranche;
    private $investor;
    private $amount;
    private $investmentDate;

    public function __construct( LoanInterface $loan , 
        TrancheInterface $tranche, 
        InvestorInterface $investor, 
        float $amount , 
        DateTime $investmentDate
    ) {
        $this->setLoan($loan);
        $this->setTranche($tranche);
        $this->setInvestor($investor);
        $this->setAmount($amount);
        $this->setInvestmentDate($investmentDate);
    }

    private function setLoan( LoanInterface $loan) : void
    {
        $this->loan = $loan;
    }

    public function getLoan() : LoanInterface
    {
        return $this->loan;
    }

    private function setTranche( TrancheInterface $tranche) : void
    {
        $this->tranche = $tranche;
    }

    public function getTranche() : TrancheInterface
    {
        return $this->tranche;
    }

    private function setInvestor( InvestorInterface $investor) : void
    {
        $this->investor = $investor;
    }

    public function getInvestor() : InvestorInterface
    {
        return $this->investor;
    }

    private function setAmount( float $amount) : void
    {
        $this->amount = $amount;
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    private function setInvestmentDate( datetime $investmentDate) : void
    {
        $this->investmentDate = $investmentDate;
    }

    public function getInvestmentDate() : datetime
    {
        return $this->investmentDate;
    }
}