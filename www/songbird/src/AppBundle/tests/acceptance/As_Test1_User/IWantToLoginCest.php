<?php
namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

class IWantToLoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    protected function login(AcceptanceTester $I)
    {
        Common::login($I, TEST1_USERNAME, TEST1_PASSWORD);
    }

    /**
     * Scenario 10.1.1
     */
    public function wrongLoginCredentials(AcceptanceTester $I) {
        Common::login($I, TEST1_USERNAME, '123');
        $I->canSee('Invalid credentials');
    }

    /**
     * Scenario 10.1.2
     * @before login
     */
    public function seeMyDashboardContent(AcceptanceTester $I) {
        $I->canSeeInCurrentUrl('/admin/dashboard');
        $I->CantSee('User Management'); 
        $I->CanSee('Dear Test1'); 
    }

    /**
     * Scenario 10.1.3
     * @before login
     */
    public function logoutSuccessfully(AcceptanceTester $I) {
        $I->click('Log out');
        // now user should be redirected to home page
        $I->seeCurrentUrlEquals('/');
    }

    /**
     * Scenario 10.1.4
     */
    public function AccessAdminWithoutLoggingIn(AcceptanceTester $I) {
        $I->amOnPage('/admin');
        // now user should be redirected to login page
        $I->canSeeInCurrentUrl('/login');
    }
}
