<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

class LoanTest extends TestCase
{

    /**
     * This is the investor class we will test. 
     * @var Loan $tranche
     * @access private
    */

    private $loan;

    /**
     * This fixtured used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     * @method void setUp()
     * @access protected
     * @return void
    */

    protected function setUp(): void
    {
        $tranches = array();

        for( $i = 0; $i < 3; $i++){
            array_push($tranches , new Tranche( 50000  , 0.3 ) );
        }


        $this->loan = new Loan( new DateTime('01/10/2015') , new DateTime('11/15/2015') , $tranches);
    }

    /**
     * We will test here that the tranche class can construct
     * @method void testTrancheCanConstruct()
     * @access public
     * @return void
    */

    public function testLoanCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\Loan' , $this->loan );
    }

    /**
     * We will test here that we can get the tranches of the loan
     * @method void testCanGetTranches()
     * @access public
     * @return void
    */

    public function testCanGetTranches() : void
    {
        $this->assertEquals( 3 ,  count($this->loan->getTranches()));
    }

    /**
     * We will test here that we can add a new tranche
     * @method void testCanaddTranche()
     * @access public
     * @return void
    */

    public function testCanAddTranche() : void
    {
        $this->loan->addTranche(new Tranche( 50000  , 0.3 ));

        $this->assertEquals( 4 ,  count($this->loan->getTranches()));
    }

    /**
     * We will test here that we can get the start date of the loan
     * @method void testCanGetStartDate()
     * @access public
     * @return void
    */

    public function testCanGetStartDate() : void
    {
        $this->assertEquals( new DateTime('01/10/2015') ,  $this->loan->getStartDate() );
    }

    /**
     * We will test here that we can get the end date of the loan
     * @method void testCanGetEndDate()
     * @access public
     * @return void
    */

    public function testCanGetEndDate() : void
    {
        $this->assertEquals( new DateTime('11/15/2015') ,  $this->loan->getEndDate() );
    }
}