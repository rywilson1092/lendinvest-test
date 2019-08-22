<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Models\Investment as Investment;

use LendInvest\Models\InterestCalculation as InterestCalculation;

use LendInvest\Models\InterestCalculations as InterestCalculations;

class InterestCalculationsTest extends TestCase
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
     * This is the interest calculation class we will test
     *
     * @var    InterestCalculation $interestCalculation
     * @access private
     */

    private $interestCalculation;

    /**
     * This is the interest calculations class we will test
     *
     * @var    InterestCalculations $interestCalculations
     * @access private
     */

    private $interestCalculations;

    /**
     * This fixture is used to setup the object that are used in the unit tests. We will test with an investor starting with 0
     *
     * @method void setUp()
     * @access protected
     * @return void
     */

    protected function setUp(): void
    {
        $this->tranche = new Tranche(1000, 0.03);

        $tranches = array( $this->tranche );

        $this->loan = new Loan(DateTime::createFromFormat('d/m/Y', '01/10/2015'), DateTime::createFromFormat('d/m/Y', '15/11/2015'), $tranches);

        $this->loan = new Loan( 
            DateTime::createFromFormat('d/m/Y', '01/10/2015'), 
            DateTime::createFromFormat('d/m/Y', '15/11/2015'), 
            $tranches
        );

        $this->investor = new Investor(1000);

        $this->investment = new Investment( 
            $this->loan, 
            $tranches[0], 
            $this->investor,
            1000,
            DateTime::createFromFormat('d/m/Y', '03/10/2015') 
        );

        $this->interestCalculation = new InterestCalculation( 
            $this->investment,
            DateTime::createFromFormat('d/m/Y', '01/10/2015'),
            DateTime::createFromFormat('d/m/Y', '31/10/2015')
        );

        $this->interestCalculations = new InterestCalculations();
    }

    /**
     * We will test here that the investment class can construct
     *
     * @method void testInterestCalculationsCanConstruct()
     * @access public
     * @return void
     */

    public function testInterestCalculationsCanConstruct() : void
    {
        $this->assertInstanceOf('LendInvest\Models\InterestCalculations', $this->interestCalculations);
    }

    /**
     * We will test here that we can get back the investment this interest calculation relates to.
     *
     * @method void testCanGetInvestmentFromInterestCalculation()
     * @access public
     * @return void
     */

    public function testCanAddInterestCalculation() : void
    {
        $this->interestCalculations->addInterestCalculation($this->interestCalculation);
        $this->assertEquals(1, count($this->interestCalculations->getInterestCalculations()));
    }
}