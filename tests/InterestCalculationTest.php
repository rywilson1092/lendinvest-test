<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Models\Investment as Investment;

use LendInvest\Models\InterestCalculation as InterestCalculation;

class InterestCalculationTest extends TestCase
{

    /**
     * This is the loan object used for testing creating an investment. 
     * @var Loan $loan
     * @access private
    */

    private $loan;

    /**
     * This is the tranche object used for testing creating an investment. 
     * @var Tranche $tranche
     * @access private
    */

    private $tranch;

    /**
     * This is the investor object used for testing creating an investment 
     * @var Investor $investor
     * @access private
    */

    private $investor;

    /**
     * This is the investment class we will test. 
     * @var Investment $investment
     * @access private
    */

    private $investment;

    /**
     * This is the interest calculation class we will test
     * @var InterestCalculation $interestCalculation
     * @access private
    */

    private $interestCalculation;

    /**
     * This fixture is used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     * @method void setUp()
     * @access protected
     * @return void
    */

    protected function setUp(): void
    {
        $this->tranche = new Tranche( 1000  , 0.03 );

        $tranches = array( $this->tranche );

        $this->loan = new Loan( new DateTime('01/10/2015') , new DateTime('11/15/2015') , $tranches );

        $this->loan = new Loan( 
            DateTime::createFromFormat('d/m/Y', '01/10/2015' ), 
            DateTime::createFromFormat('d/m/Y', '15/11/2015' ), 
            $tranches
        );

        $this->investor = new Investor( 1000 );

        $this->currentDateTime = new datetime();

        $this->investment = new Investment( 
            $this->loan, 
            $tranches[0], 
            $this->investor,
            1000,
            DateTime::createFromFormat('d/m/Y', '03/10/2015' ) 
        );

        $this->interestCalculation = new InterestCalculation( 
            $this->investment,
            DateTime::createFromFormat('d/m/Y', '01/10/2015' ),
            DateTime::createFromFormat('d/m/Y', '31/10/2015' )
        );
    }

    /**
     * We will test here that the investment class can construct
     * @method void testInterestCalculationCanConstruct()
     * @access public
     * @return void
    */

    public function testInterestCalculationCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\InterestCalculation' , $this->interestCalculation );
    }

    /**
     * We will test here that we can get back the investment this interest calculation relates to.
     * @method void testCanGetInvestmentFromInterestCalculation()
     * @access public
     * @return void
    */

    public function testCanGetInvestmentFromInterestCalculation() : void
    {
        $this->assertEquals( $this->investment , $this->interestCalculation->getInvestment() );
    }

    /**
     * We will test here that we get back the correct amount of interest
     * @method void testCanGetBackCorrectInterestAmount()
     * @access public
     * @return void
    */

    public function testCanGetBackCorrectInterestAmount() : void
    {
        $this->assertEquals( 28.06 , $this->interestCalculation->getInterest() );
    }
}