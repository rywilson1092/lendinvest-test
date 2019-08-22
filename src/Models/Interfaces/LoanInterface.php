<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use LendInvest\Models\Interfaces\TrancheInterface;

use DateTime;

interface LoanInterface
{

    public function addTranche( TrancheInterface $tranche ) : void;

    public function getTranches() : array;

    public function getStartDate() : DateTime;

    public function getEndDate() : DateTime;
}