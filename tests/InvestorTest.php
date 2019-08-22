<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Investor as Investor;

class InvestorTest extends TestCase
{

    /**
     * This is the investor class we will test. 
     *
     * @var    Investor $investor
     * @access private
     */

    private $investor;

    /**
     * This fixtured used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     *
     * @method void setUp()
     * @access protected
     * @return void
     */

    protected function setUp(): void
    {
        $this->investor = new Investor(0);
    }

    /**
     * We will test here that the investor class can construct
     *
     * @method void testInvestorCanConstruct()
     * @access public
     * @return void
     */

    public function testInvestorCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\Investor', $this->investor);
    }

    /**
     * We will test here that we can get the investors wallet balance
     *
     * @method void testCanGetWalletBalance()
     * @access public
     * @return void
     */

    public function testCanGetWalletBalance() : void
    {
        $this->assertIsFloat($this->investor->getWalletBalance());
    }

    /**
     * We will test here that we can add funds
     *
     * @method void testCanAddFunds()
     * @access public
     * @return void
     */

    public function testCanAddFunds() : void
    {
        $this->investor->addFunds(25.53);
        $this->assertEquals(25.53, $this->investor->getWalletBalance());
    }

    /**
     * We will test here that we can subtract funds
     *
     * @method void testCanSubtractFunds()
     * @access public
     * @return void
     */

    public function testCanSubtractFunds() : void
    {
        $this->investor->addFunds(25.53);
        $this->investor->subtractFunds(20);
        $this->assertEquals(5.53, $this->investor->getWalletBalance());
    }

    /**
     * We will test here that an exception is thrown if not enough funds
     *
     * @method void testThrowsExceptionIfTooMuchSubtract()
     * @access public
     * @return void
     */

    public function testThrowsExceptionIfTooMuchSubtract() : void
    {
        $this->expectExceptionMessage("Cannot subtract when amount is larger than wallet balance!");
        $this->investor->subtractFunds(2000);
    }
}