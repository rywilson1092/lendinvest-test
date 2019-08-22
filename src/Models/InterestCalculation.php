<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InterestCalculationInterface;
use LendInvest\Models\Interfaces\InvestmentInterface;

use Datetime;

class InterestCalculation implements InterestCalculationInterface
{

    private $investment;
    private $startDate;
    private $endDate;
    private $interest;

    public function __construct( InvestmentInterface $investment , DateTime $startDate , DateTime $endDate)
    {
        $this->investment = $investment;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->interest = $this->calculateInterest();
    }

    public function getInvestment() : InvestmentInterface
    {
        return $this->investment;
    }

    public function getInterest() : float
    {
        return $this->interest;
    }

    private function calculateInterest() : float
    {

        /* Calculate Daily Interest */
        $dailyInterestRate = $this->calculateDailyInterestRate();

        //echo '<pre>'; var_dump($interestDays); exit();

        /* Calculate daily Interest Amount */
        $dailyInterestAmount = $this->investment->getAmount() * $dailyInterestRate;

        /* Calculate days interest can apply to */
        $interestDays = $this->calculateInterestDays();

        

        return round($interestDays * $dailyInterestAmount, 2);
    }

    private function calculateDailyInterestRate() : float
    {
        return $this->investment->getTranche()->getInterestRate() / cal_days_in_month(
            CAL_GREGORIAN,
            (int) $this->endDate->format('m'),
            (int)$this->endDate->format('Y')
        );
    }

    private function calculateInterestDays() : int
    {

        $interestDays = 0;
        
        if(($this->investment->getInvestmentDate()->getTimestamp() > $this->startDate->getTimestamp())
            
            && ($this->investment->getInvestmentDate()->getTimestamp() < $this->endDate->getTimestamp())
        ) {
            $interestDays += $this->endDate->diff($this->investment->getInvestmentDate())->format("%a") + 1; 
        }else if(($this->investment->getInvestmentDate()->getTimestamp() < $this->startDate->getTimestamp())
            
            && ($this->investment->getInvestmentDate()->getTimestamp() < $this->endDate->getTimestamp())
        ) {
            $interestDays += $this->endDate->diff($this->startDate)->format("%a") + 1; 
        }

        return $interestDays;
    }
}