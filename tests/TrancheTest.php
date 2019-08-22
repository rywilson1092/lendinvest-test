<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Tranche as Tranche;

class TrancheTest extends TestCase
{

    /**
     * This is the investor class we will test. 
     * @var Tranche $tranche
     * @access private
    */

    private $tranche;

    /**
     * This fixtured used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     * @method void setUp()
     * @access protected
     * @return void
    */

    protected function setUp(): void
    {
        $this->tranche = new Tranche( 50000  , 0.3 );
    }

    /**
     * We will test here that the tranche class can construct
     * @method void testTrancheCanConstruct()
     * @access public
     * @return void
    */

    public function testTrancheCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\Tranche' , $this->tranche );
    }

    /**
     * We will test here that we can get the maximum investment
     * @method void testCanGetMaximumInvestment()
     * @access public
     * @return void
    */

    public function testCanGetMaximumInvestment() : void
    {
        $this->assertEquals( 50000 , $this->tranche->getMaximumInvestment());
    }

     /**
     * We will test here  that we can get the remaining investment
     * @method void testCanGetRemainingInvestment()
     * @access public
     * @return void
    */

    public function testCanGetRemainingInvestment() : void
    {
        $this->assertEquals( 50000 , $this->tranche->getRemainingInvestment());
    }

    /**
     * We will test here that we can invest in the tranche
     * @method void testCanMakeInvestment()
     * @access public
     * @return void
    */

    public function testCanMakeInvestment() : void
    {
        $this->tranche->makeInvestment(100);

        $this->assertEquals( 49900 , $this->tranche-> getRemainingInvestment());
    }

    /**
     * We will test here that an exception is thrown when not enough remaining
     * @method void testCanMakeInvestmentThrowsErrorWhenNotEnoughRemaining()
     * @access public
     * @return void
    */

    public function testCanMakeInvestmentThrowsErrorWhenNotEnoughRemaining() : void
    {
        $this->expectExceptionMessage("Not enough remaining to invest");

        $this->tranche->makeInvestment(1000000000);
    }
}