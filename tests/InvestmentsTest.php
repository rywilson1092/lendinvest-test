<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Validators\InvestmentValidator as InvestmentValidator;

use LendInvest\Models\Investment as Investment;

use LendInvest\Models\Investments as Investments;

class InvestmentsTest extends TestCase
{

    /**
     * This is the loan object used for creating an investment. 
     *
     * @var    Loan $loan
     * @access private
     */

    private $loan;

    /**
     * This is the tranche object used for creating an investment. 
     *
     * @var    Tranche $tranche
     * @access private
     */

    private $tranch;

    /**
     * This is the investor object used for creating an investment 
     *
     * @var    Investor $investor
     * @access private
     */

    private $investor;

    /**
     * This is the investor is very rich! 
     *
     * @var    Investor $veryRichInvestor
     * @access private
     */

    private $veryRichInvestor;

    /**
     * This is the investmentvalidator class we use to inject into investments class. 
     *
     * @var    InvestmentValidator $investmentValidator
     * @access private
     */

    private $investmentValidator;


    /**
     * This is the investments class we will test. 
     *
     * @var    Investments $investments
     * @access private
     */

    private $investments;



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

        $this->loan = new Loan(new DateTime('01/10/2015'), new DateTime('11/11/2015'), $tranches);

        $this->investor = new Investor(500);

        $this->veryRichInvestor = new Investor(50000000000);

        $this->investmentValidator = new InvestmentValidator();

        $this->investments = new Investments($this->investmentValidator);
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
        $this->assertInstanceOf('LendInvest\Models\Investments', $this->investments);
    }

    /**
     * We will test here that we can get the loan of the investment
     *
     * @method void testCanSubmitCorrectInvestment()
     * @access public
     * @return void
     */

    public function testCanSubmitCorrectInvestment() : void
    {
        $correctInvestment = new Investment($this->loan, $this->tranche, $this->investor, 200, new DateTime("10/11/2015"));

        $this->assertTrue($this->investments->submitInvestment($correctInvestment));
    }

    /**
     * We will test here that we can get the investments
     *
     * @method void testCanGetInvestments()
     * @access public
     * @return void
     */

    public function testCanGetInvestments() : void
    {
        $correctInvestment = new Investment($this->loan, $this->tranche, $this->investor, 200, new DateTime("10/11/2015"));

        $this->investments->submitInvestment($correctInvestment);

        $this->assertIsArray($this->investments->getInvestments());
        $this->assertEquals(1, count($this->investments->getInvestments()));
    }

    /**
     * We will test here that the amount remaining on the invested tranche decreases.
     *
     * @method void testTrancheDecreases()
     * @access public
     * @return void
     */

    public function testTrancheAndWalletDecreases() : void
    {
        $correctInvestment = new Investment($this->loan, $this->tranche, $this->investor, 200, new DateTime("10/11/2015"));

        $this->investments->submitInvestment($correctInvestment);

        $this->assertEquals(49800, $this->tranche->getRemainingInvestment());
        $this->assertEquals(300, $this->investor->getWalletBalance());
    }

    /**
     * We will test here that we get exception when investment date after loan end date
     *
     * @method void testCannotSubmitAfterLoanEndDate()
     * @access public
     * @return void
     */

    public function testCannotSubmitAfterLoanEndDate() : void
    {
        $invalidInvestment = new Investment($this->loan, $this->tranche, $this->investor, 200, new DateTime("12/11/2015"));

        $this->expectExceptionMessage("Loan has expired.");

        $this->investments->submitInvestment($invalidInvestment);
    }

    /**
     * We will test here that we get exception when tranche is oversubscribed
     *
     * @method void testCannotSubmitTrancheOversubscribed()
     * @access public
     * @return void
     */

    public function testCannotSubmitTrancheOversubscribed() : void
    {
        $invalidInvestment = new Investment($this->loan, $this->tranche, $this->veryRichInvestor, 500000, new DateTime("10/11/2015"));

        $this->expectExceptionMessage("Not enough remaining in tranche");

        $this->investments->submitInvestment($invalidInvestment);
    }

    /**
     * We will test here that we get exception when the user does not have enough in their wallet
     *
     * @method void testCannotSubmitNotEnoughWallet()
     * @access public
     * @return void
     */

    public function testCannotSubmitNotEnoughWallet() : void
    {
        $invalidInvestment = new Investment($this->loan, $this->tranche, $this->investor, 1000, new DateTime("10/11/2015"));

        $this->expectExceptionMessage("Not enough money in wallet");

        $this->investments->submitInvestment($invalidInvestment);
    }
}