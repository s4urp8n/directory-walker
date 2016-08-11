<?php

class RemoveMeUnitCest
{
    
    public function youCanRemoveThisTest1(UnitTester $I)
    {
        /**
         * Test autoloading from /tests/classes
         */
        
        $autoloaded = new Demo\DemoRemoveMe1();
        $autoloaded = new Demo\DemoRemoveMe2();
        $autoloaded = new DemoRemoveMe();
        
        /**
         * Test PackageTemplate::testFile()
         */
        $I->assertSame(
            realpath(
                __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'demo.gif'
            ), PackageTemplate\testFile('demo.gif')
        );
        
        $I->assertSame(RemoveMe::method1(), 1);
    }
    
    public function youCanRemoveThisTest2(UnitTester $I)
    {
        $I->assertSame(RemoveMe::method2(), 2);
    }
    
}