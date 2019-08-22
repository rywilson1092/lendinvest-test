<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use LendInvest\Models\Loan as Loan;

use LendInvest\Models\Tranche as Tranche;

use LendInvest\Models\Investor as Investor;

use LendInvest\Validators\InvestmentValidator as InvestmentValidator;

use LendInvest\Models\Investment as Investment;

use LendInvest\Models\Investments as Investments;

use LendInvest\Models\InterestRunner as InterestRunner;

class ScenarioTest extends TestCase
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
     * @var    Tranche $trancheA
     * @access private
     */

    private $tranchA;

    /**
     * This is the tranche object used for creating an investment. 
     *
     * @var    Tranche $trancheB
     * @access private
     */

    private $tranchB;

    /**
     * This is the investor object used for creating an investment 
     *
     * @var    Investor $investor1
     * @access private
     */

    private $investor1;

    /**
     * This is the investor object used for creating an investment 
     *
     * @var    Investor $investor2
     * @access private
     */

    private $investor2;

    /**
     * This is the investor object used for creating an investment 
     *
     * @var    Investor $investor3
     * @access private
     */

    private $investor3;

    /**
     * This is the investor object used for creating an investment 
     *
     * @var    Investor $investor4
     * @access private
     */

    private $investor4;

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
        $this->trancheA = new Tranche(1000, 0.03);

        $this->trancheB = new Tranche(1000, 0.06);

        $tranches = array( $this->trancheA , $this->trancheB );

        $this->loan = new Loan( 
            DateTime::createFromFormat('d/m/Y', '01/10/2015'), 
            DateTime::createFromFormat('d/m/Y', '15/11/2015'), 
            $tranches
        );

        $this->investor1 = new Investor(1000);
        $this->investor2 = new Investor(1000);
        $this->investor3 = new Investor(1000);
        $this->investor4 = new Investor(1000);

        $this->investmentValidator = new InvestmentValidator();

        $this->investments = new Investments($this->investmentValidator);
    }

    /**
     * We will test here that we can get the loan of the investment
     *
     * @method void testInvestor2ReceivesOverSubscribedException()
     * @access public
     * @return void
     */

    public function testInvestor2ReceivesOverSubscribedException() : void
    {
        $investor1Investment = new Investment( 
            $this->loan, 
            $this->trancheA, 
            $this->investor1,
            1000,
            DateTime::createFromFormat('d/m/Y', '03/10/2015')
        );

        $this->assertTrue($this->investments->submitInvestment($investor1Investment));

        $investor2Investment = new Investment( 
            $this->loan, 
            $this->trancheA, 
            $this->investor2,
            1,
            DateTime::createFromFormat('d/m/Y', '04/10/2015')
        );

        $this->expectExceptionMessage("Not enough remaining in tranche");

        $this->investments->submitInvestment($investor2Investment);
    }

    /**
     * We will test here that investor 4 recieves an exception for not having enough wallet funds.
     *
     * @method void testInvestor4ReceivesNotEnoughWalletException()
     * @access public
     * @return void
     */

    public function testInvestor4ReceivesNotEnoughWalletException() : void
    {
        $investor3Investment = new Investment( 
            $this->loan, 
            $this->trancheB, 
            $this->investor3,
            500,
            DateTime::createFromFormat('d/m/Y', '10/10/2015')
        );

        $this->assertTrue($this->investments->submitInvestment($investor3Investment));

        $investor4Investment = new Investment( 
            $this->loan, 
            $this->trancheB, 
            $this->investor4,
            1100,
            DateTime::createFromFormat('d/m/Y', '25/10/2015')
        );

        $this->expectExceptionMessage("Not enough money in wallet");

        $this->investments->submitInvestment($investor4Investment);
    }

     /**
      * We will test here that the two investors recieve their correct interest
      *
      * @method void testInvestorsRecieveCorrectInterest()
      * @access public
      * @return void
      */

    public function testInvestorsReceiveCorrectInterest() : void
    {

        $investor1Investment = new Investment( 
            $this->loan, 
            $this->trancheA, 
            $this->investor1,
            1000,
            DateTime::createFromFormat('d/m/Y', '03/10/2015')
        );

        $investor3Investment = new Investment( 
            $this->loan, 
            $this->trancheB, 
            $this->investor3,
            500,
            DateTime::createFromFormat('d/m/Y', '10/10/2015')
        );

        $this->investments->submitInvestment($investor1Investment);
        $this->investments->submitInvestment($investor3Investment);

        /* Run the interest runner */
        $interestRunner = new InterestRunner( 
            $this->investments,
            DateTime::createFromFormat('d/m/Y', '01/10/2015'),
            DateTime::createFromFormat('d/m/Y', '31/10/2015')
        );

        $interestCalculationsObj = $interestRunner->getInterestCalculationsObj();

        $interestCalculations = $interestCalculationsObj->getInterestCalculations();

        /* Check that the interest calculations have worked by checking transaction and wallet balance */

        $this->assertEquals(28.06, $interestCalculations[0]->getInterest());
        $this->assertEquals(21.29, $interestCalculations[1]->getInterest());

        $this->assertEquals(28.06, $this->investor1->getWalletBalance());
        $this->assertEquals(521.29, $this->investor3->getWalletBalance());

    }

}