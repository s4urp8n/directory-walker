<?php

use Zver\DirectoryWalker;

class DirectoryWalkerCest
{
    
    public function mainTest(UnitTester $I)
    {
        $testData = [
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up()
                                          ->up()
                                          ->enter('tests')
                                          ->enter('unit')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up(2)
                                          ->enter('tests')
                                          ->enter('unit')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up(2)
                                          ->enter('tests////unit')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up(2)
                                          ->enter('tests/unit')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
        
        ];
        
        foreach ($testData as $data)
        {
            $I->assertSame($data[0](), $data[1]);
        }
    }
    
    public function includeTest(UnitTester $I)
    {
        $I->assertFalse(class_exists('\DirectoryWalkerTest\SupaDupaUniqClass', false));
        
        DirectoryWalker::fromCurrent()
                       ->up(2)
                       ->enter('package/tests/files')
                       ->includeFile('SupaDupaUniqClass.php');
        
        $I->assertTrue(class_exists('\DirectoryWalkerTest\SupaDupaUniqClass', false));
        
        $I->expectException(
            'Zver\Exceptions\DirectoryWalker\FileNotFoundException', function ()
        {
            DirectoryWalker::fromCurrent()
                           ->includeFile('238dsdcnsdnsdnvcuisd', true);
        }
        );
    }
    
    public function requireTest(UnitTester $I)
    {
        $I->assertFalse(class_exists('\DirectoryWalkerTest\SupaDupaUniqClass2', false));
        
        DirectoryWalker::fromCurrent()
                       ->up(2)
                       ->enter('package/tests/files')
                       ->requireFile('SupaDupaUniqClass2.php');
        
        $I->assertTrue(class_exists('\DirectoryWalkerTest\SupaDupaUniqClass2', false));
        
        $I->expectException(
            'Zver\Exceptions\DirectoryWalker\FileNotFoundException', function ()
        {
            DirectoryWalker::fromCurrent()
                           ->requireFile('238dsdcnsdnsdnvcuisd', true);
        }
        );
    }
    
}