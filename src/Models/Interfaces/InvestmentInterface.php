<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\LoanInterface;
use LendInvest\Models\Interfaces\TrancheInterface;
use LendInvest\Models\Interfaces\InvestorInterface;

use DateTime;

interface InvestmentInterface{

    public function getLoan() : LoanInterface;

    public function getTranche() : TrancheInterface;

    public function getInvestor() : InvestorInterface;

    public function getAmount() : float;

    public function getInvestmentDate() : datetime;
}