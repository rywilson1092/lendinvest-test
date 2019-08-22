<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Validators;

use LendInvest\Validators\Interfaces\InvestmentValidatorInterface;

use Datetime;

class InvestmentValidator implements InvestmentValidatorInterface{

    public function validateIsInvestmentBeforeLoanEndDate( datetime $endDate , datetime $investmentDate) : bool {

        if($investmentDate->getTimestamp() < $endDate->getTimestamp()){
            return true;
        }else{
            return false;
        }

    }

    public function validateIsTrancheEnoughRemaining( float $amountRemaining , float $amount ) : bool{

        if($amount <= $amountRemaining){
            return true;
        }else{
            return false;
        }
    }

    public function validateWalletBalance( float $walletBalance , float $investmentAmount )  : bool{

        if($investmentAmount <= $walletBalance){
            return true;
        }else{
            return false;
        }
    }
}