<?php


class AppBundleCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // replace InstallationTest by RemovalTest
    public function RemovalTest(AcceptanceTester $I)
    {
        $I->wantTo('Check if / is not active.');
        $I->amOnPage('/');
        $I->see('404 Not Found');
        $I->wait(5);
    }
}
