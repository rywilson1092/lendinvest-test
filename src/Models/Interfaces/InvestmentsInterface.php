<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\InvestmentInterface;

interface InvestmentsInterface
{

    public function submitInvestment( InvestmentInterface $investment ) : bool;

    public function getInvestments() : array;
}