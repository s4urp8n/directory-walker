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
                                          ->enter('\\\\/////tests\\\\///////unit///\\\\')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up(2)
                                          ->enter('tests\\\\unit')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->up(2)
                                          ->enter('tests\unit')
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
    
}