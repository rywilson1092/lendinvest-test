<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Models\Investment as Investment;

class InvestmentTest extends TestCase
{

    /**
     * This is the loan object used for testing creating an investment. 
     *
     * @var    Loan $loan
     * @access private
     */

    private $loan;

    /**
     * This is the tranche object used for testing creating an investment. 
     *
     * @var    Tranche $tranche
     * @access private
     */

    private $tranch;

    /**
     * This is the investor object used for testing creating an investment 
     *
     * @var    Investor $investor
     * @access private
     */

    private $investor;

    /**
     * This is the investment class we will test. 
     *
     * @var    Investment $investment
     * @access private
     */

    private $investment;

    /**
     * This fixture is used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     *
     * @method void setUp()
     * @access protected
     * @return void
     */

    protected function setUp(): void
    {
        $this->tranche = new Tranche(50000, 0.3);

        $tranches = array( $this->tranche );

        $this->loan = new Loan(new DateTime('01/10/2015'), new DateTime('11/15/2015'), $tranches);

        $this->investor = new Investor(500);
        

        $this->investment = new Investment($this->loan, $tranches[0], $this->investor, 200, DateTime::createFromFormat('d/m/Y', '01/10/2015'));

    }

    /**
     * We will test here that the investment class can construct
     *
     * @method void testInvestmentCanConstruct()
     * @access public
     * @return void
     */

    public function testInvestmentCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\Investment', $this->investment);
    }

    /**
     * We will test here that we can get the loan of the investment
     *
     * @method void testCanGetLoan()
     * @access public
     * @return void
     */

    public function testCanGetLoan() : void
    {
        $this->assertEquals($this->loan, $this->investment->getLoan());
    }

    /**
     * We will test here that we can get the tranche of the investment
     *
     * @method void testCanGetTranche()
     * @access public
     * @return void
     */

    public function testCanGetTranche() : void
    {
        $this->assertEquals($this->tranche, $this->investment->getTranche());
    }

    /**
     * We will test here that we can get the investor of the investment
     *
     * @method void testCanGetInvestor()
     * @access public
     * @return void
     */

    public function testCanGetInvestor() : void
    {
        $this->assertEquals($this->investor, $this->investment->getInvestor());
    }

    /**
     * We will test here that we can get the amount of the investment
     *
     * @method void testCanGetAmount()
     * @access public
     * @return void
     */

    public function testCanGetAmount() : void
    {
        $this->assertEquals(200, $this->investment->getAmount());
    }

    /**
     * We will test here that we can get the date of the investment
     *
     * @method void testCanGetInvestmentDate()
     * @access public
     * @return void
     */

    public function testCanGetInvestmentDate() : void
    {
        $this->assertEquals(DateTime::createFromFormat('d/m/Y', '01/10/2015'), $this->investment->getInvestmentDate());
    }
}