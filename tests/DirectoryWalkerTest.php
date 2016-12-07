<?php

use Zver\DirectoryWalker;

class DirectoryWalkerTest extends PHPUnit\Framework\TestCase
{
    
    use \Package\Test;
    
    public function testGet()
    {
        
        $this->foreachSame(
            [
                [
                    DirectoryWalker::fromCurrent()
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes')
                                   ->enter('Package')
                                   ->up()
                                   ->up()
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes\Package')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes\\Package')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes/Package')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes//Package')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('./classes/./Package')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('./')
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('.')
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('///classes\\\\///////Package\\\\')
                                   ->up(2)
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('someDir')
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR . "someDir" . DIRECTORY_SEPARATOR,
                ],
            ]
        );
        
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
    
    public function testUpTo()
    {
        $this->foreachSame(
            [
                [
                    DirectoryWalker::fromCurrent()
                                   ->enter('classes')
                                   ->enter('Package')
                                   ->upUntil('tests')
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    DirectoryWalker::fromCurrent()
                                   ->upUntil('tests')
                                   ->get(),
                    __DIR__ . DIRECTORY_SEPARATOR,
                ],
                [
                    /**
                     * up to root directory
                     */
                    DirectoryWalker::fromCurrent()
                                   ->up()
                                   ->enter('src')
                                   ->upUntil('tests')
                                   ->get(),
                    explode(DIRECTORY_SEPARATOR, __DIR__)[0] . DIRECTORY_SEPARATOR,
                ],
            ]
        );
    }
    
}