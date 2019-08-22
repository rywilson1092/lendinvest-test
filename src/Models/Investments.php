<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InvestmentsInterface;
use LendInvest\Models\Interfaces\InvestmentInterface;

use LendInvest\Validators\Interfaces\InvestmentValidatorInterface;

use Exception;

class Investments implements InvestmentsInterface
{

    private $investmentValidator;

    private $investments = array();

    public function __construct( InvestmentValidatorInterface $investmentValidator)
    {
        $this->investmentValidator = $investmentValidator;
    }

    public function submitInvestment( InvestmentInterface $investment ) : bool
    {
        $this->validateInvestment($investment);

        $investment->getTranche()->makeInvestment($investment->getAmount());

        $investment->getInvestor()->subtractFunds($investment->getAmount());

        array_push($this->investments, $investment);

        return true;
    }

    private function validateInvestment( InvestmentInterface $investment ) : void
    {

        $this->validateInvestmentDate($investment);
        $this->validateWalletBalance($investment);
        $this->validateAmountRemaining($investment);
    } 

    private function validateInvestmentDate( InvestmentInterface $investment ) : void
    {
        if(!$this->investmentValidator->validateIsInvestmentBeforeLoanEndDate( 
            $investment->getLoan()->getEndDate(), 
            $investment->getInvestmentDate()
        )
        ) {
            throw new exception("Loan has expired.");
        }
    }

    private function validateAmountRemaining( InvestmentInterface $investment  ) : void
    {

        if(!$this->investmentValidator->validateIsTrancheEnoughRemaining( 
            $investment->getTranche()->getRemainingInvestment(), 
            $investment->getAmount()
        )    
        ) {
            throw new exception("Not enough remaining in tranche");
        }
    }

    private function validateWalletBalance( InvestmentInterface $investment  ) : void
    {

        if(!$this->investmentValidator->validateWalletBalance( 
            $investment->getInvestor()->getWalletBalance(), 
            $investment->getAmount() 
        )
        ) {
            throw new exception("Not enough money in wallet");
        }
    }

    public function getInvestments() : array
    {
        return $this->investments;
    }
}