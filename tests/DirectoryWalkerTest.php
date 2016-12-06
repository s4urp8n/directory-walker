<?php

use Zver\DirectoryWalker;

class DirectoryWalkerTest extends PHPUnit\Framework\TestCase
{
    
    public function testGet()
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
                                          ->enter('classes')
                                          ->enter('Package')
                                          ->up()
                                          ->up()
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('classes\Package')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('classes\\Package')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('classes/Package')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('classes//Package')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('./classes/./Package')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('./')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('.')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('///classes\\\\///////Package\\\\')
                                          ->up(2)
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR,
            ],
            [
                function ()
                {
                    return DirectoryWalker::fromCurrent()
                                          ->enter('someDir')
                                          ->get();
                },
                __DIR__ . DIRECTORY_SEPARATOR . "someDir" . DIRECTORY_SEPARATOR,
            ],
        ];
        
        foreach ($testData as $data)
        {
            $this->assertSame($data[0](), $data[1]);
        }
        
    }
    
    public function testCreateAndGet()
    {
        $dirName = 'fsdavchsfewf';
        $path = DirectoryWalker::fromCurrent()
                               ->enter($dirName);
        
        if (file_exists($path->get()))
        {
            rmdir($path->get());
        }
        
        $this->assertFalse(file_exists($path->get()));
        
        $path->createAndGet();
        
        $this->assertTrue(file_exists($path->get()));
        
        if (file_exists($path->get()))
        {
            rmdir($path->get());
        }
        
    }
    
}