<?php
namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

class IShouldNotBeAbleToManageOtherProfilesCest
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
     * Scenario 10.5.1
     * @before login
     */
    public function listAllProfiles(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/app/user/list');
        $I->canSee('Access Denied');
    }

    /**
     * Scenario 10.5.2
     * @before login
     */
    public function showTest2Profile(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/app/user/3/show');
        $I->canSee('Access Denied');
    }

    /**
     * Scenario 10.5.3
     * @before login
     */
    public function editTest2Profile(AcceptanceTester $I)
    {
        $I->amOnPage('/admin/app/user/3/edit');
        $I->canSee('Access Denied');
    }

     /**
     * Scenario 10.5.4
     * @before login
     */
    public function seeAdminDashboardContent(AcceptanceTester $I) {
        $I->cantSee('admin','//h3[@class="box-title"]');
    }
}
