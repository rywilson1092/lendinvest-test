<?php

declare(strict_types=1);
namespace LendInvest;
namespace LendInvest\Models;

use LendInvest\Models\Interfaces\InvestorInterface;

use Exception;

class Investor implements InvestorInterface
{

    private $walletBalance;

    public function __construct( float $walletBalance )
    {
        $this->setWalletBalance($walletBalance);
    }

    public function getWalletBalance() : float
    {
        return $this->walletBalance;
    }

    private function setWalletBalance( float $walletBalance ) : void
    {
        $this->walletBalance = $walletBalance;
    }

    public function addFunds( float $amount ) : void
    {
        $this->walletBalance += $amount;
    }

    public function subtractFunds( float $amount ) : void
    {

        if($amount > $this->walletBalance) {
            throw new Exception("Cannot subtract when amount is larger than wallet balance!");
        }

        $this->walletBalance -= $amount;
    }
}