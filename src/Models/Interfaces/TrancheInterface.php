<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

use DateTime;

interface TrancheInterface{

    public function getMaximumInvestment() : float;

    public function getCurrentInvestment() : float;

    public function getRemainingInvestment() : float;

    public function getInterestRate() : float;

    public function makeInvestment( float $amount ) : void;
}