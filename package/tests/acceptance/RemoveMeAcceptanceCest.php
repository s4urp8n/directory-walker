<?php

class RemoveMeAcceptanceCest
{
    
    public function youCanRemoveThisTest1(AcceptanceTester $I)
    {
        $I->amOnPage(PackageTemplate\page('page1'));
        $I->seeResponseCodeIs(200);
        $I->see('Page1');
    }
    
    public function youCanRemoveThisTest2(AcceptanceTester $I)
    {
        $I->amOnPage(PackageTemplate\page('page2'));
        $I->seeResponseCodeIs(200);
        $I->see('Page2');
    }
}