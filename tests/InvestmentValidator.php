<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Models\Investment as Investment;

use LendInvest\Models\InvestmentValidator as InvestmentValidator;

use DateTime;

class InvestmentValidatorTest extends TestCase
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
     * This is the investment we use to test investment validator
     *
     * @var    Investment $investment
     * @access private
     */

    private $investment;

    /**
     * This is the investmentvalidator class we will test. 
     *
     * @var    InvestmentValidator $investmentValidator
     * @access private
     */

    private $investmentValidator;



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

        $tranches = array( $tranche );

        $this->loan = new Loan(new DateTime('01/10/2015'), new DateTime('11/15/2015'), $tranches);

        $this->investor = new Investor(500);

        $this->investment = new Investment($this->loan, $tranches[0], $this->investor, 200, DateTime::createFromFormat('d/m/Y', '01/10/2015'));

        $this->investmentValidator = new InvestmentValidator();

    }

    /**
     * We will test here that the investmentvalidator class can construct
     *
     * @method void testInvestmentValidatorCanConstruct()
     * @access public
     * @return void
     */

    public function testInvestmentValidatorCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Validator\InvestmentValidator', $this->investmentValidator);
    }

    /**
     * We will test here that end date check works in correct scenario
     *
     * @method void testEndDateValidatorIsTrue()
     * @access public
     * @return void
     */

    public function testEndDateValidatorIsTrue() : void
    {
        $this->assertTrue($this->investmentValidator->validateIsInvestmentBeforeLoanEndDate(new DateTime("01/05/2015"), new DateTime("10/04/2015")));
    }

     /**
      * We will test here that end date check works in incorrect scenario
      *
      * @method void testEndDateValidatorIsFalse()
      * @access public
      * @return void
      */

    public function testEndDateValidatorIsFalse() : void
    {
        $this->assertFalse($this->investmentValidator->validateIsInvestmentBeforeLoanEndDate(new DateTime("01/05/2015"), new DateTime("10/05/2015")));
    }

    /**
     * We will test here that the amount remaining check works in correct scenario
     *
     * @method void testAmountRemainingValidatorIsTrue()
     * @access public
     * @return void
     */

    public function testAmountRemainingValidatorIsTrue() : void
    {
        $this->assertTrue($this->investmentValidator->validateIsTrancheEnoughRemaining(10, 5));
    }

    /**
     * We will test here that end date check works in incorrect scenario
     *
     * @method void testEndDateValidatorIsFalse()
     * @access public
     * @return void
     */

    public function testAmountRemainingValidatorIsFalse() : void
    {
        $this->assertFalse($this->investmentValidator->validateIsTrancheEnoughRemaining(5, 10));
    }

    /**
     * We will test here that it validates that the user has enough in their wallet
     *
     * @method void testWalletBalanceValidatorIsTrue()
     * @access public
     * @return void
     */

    public function testWalletBalanceValidatorIsTrue() : void
    {
        $this->assertTrue($this->investmentValidator->validateWalletBalance(10, 5));
    }

    /**
     * We will test here that end date check works in incorrect scenario
     *
     * @method void testWalletBalanceValidatorIsFalse()
     * @access public
     * @return void
     */

    public function testWalletBalanceValidatorIsFalse() : void
    {
        $this->assertFalse($this->investmentValidator->validateWalletBalance(5, 10));
    }
}