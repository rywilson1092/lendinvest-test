<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;
namespace LendInvest\Models\Interfaces;

interface InvestorInterface
{

    public function getWalletBalance() : float;

    public function addFunds( float $amount ) : void;

    public function subtractFunds( float $amount ) : void;
}