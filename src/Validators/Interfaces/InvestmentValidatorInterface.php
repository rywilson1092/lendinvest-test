<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Validators;
namespace LendInvest\Validators\Interfaces;

use Datetime;

interface InvestmentValidatorInterface
{

    public function validateIsInvestmentBeforeLoanEndDate( datetime $endDate , datetime $investmentDate) : bool;

    public function validateIsTrancheEnoughRemaining( float $amountRemaining , float $amount ) : bool;

    public function validateWalletBalance( float $walletBalance , float $investmentAmount ) : bool;
}