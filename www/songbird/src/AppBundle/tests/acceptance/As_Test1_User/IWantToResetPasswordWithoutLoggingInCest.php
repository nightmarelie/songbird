<?php
namespace As_Test1_User;
use \AcceptanceTester;
use \Common;

class IWantToResetPasswordWithoutLoggingInCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    protected function login(AcceptanceTester $I, $username=TEST1_USERNAME, $password=TEST1_PASSWORD)
    {
        Common::login($I, $username, $password);
    }

    /**
     * Scenario 12.1.1
     */
    public function resetPasswordSuccessfully(AcceptanceTester $I)
    {
        // reset emails
        $I->resetEmails();
        $I->amOnPage('/login');
        $I->click('forget password');
        $I->fillField('//input[@id="username"]', 'test1');
        $I->click('_submit');
        $I->canSee('It contains a link');

       // Clear old emails from MailCatcher
        $I->seeInLastEmail("Hello test1");
        $link = $I->grabFromLastEmail('@http://(.*)@');
        $I->amOnUrl($link);

        // The password has been reset successfully
        $I->fillField('//input[@id="fos_user_resetting_form_plainPassword_first"]', '1111');
        $I->fillField('//input[@id="fos_user_resetting_form_plainPassword_second"]', '1111');
        $I->click('_submit');
        $I->canSee('The password has been reset successfully');
        $I->canSeeInCurrentUrl('/admin/dashboard');
        // now login with the new password
        $this->login($I, TEST1_USERNAME, '1111');
        // db has been changed. update it back
        $I->amOnPage('/admin/app/user/2/edit');
        $I->fillField('//input[contains(@id, "_plainPassword_first")]', TEST1_USERNAME);
        $I->fillField('//input[contains(@id, "_plainPassword_second")]', TEST1_PASSWORD);
        $I->click('btn_update_and_edit');
        $I->canSee('has been successfully updated');
        // As a test, i should be able to login with the old password
        $this->login($I);
        $I->canSeeInCurrentUrl('/admin/dashboard');
    }
}
