<?php
/**
 * Example description of removeMe file
 *
 * @package      Some Package
 * @subpackage   Some Subpackage
 * @category     Some Category
 * @author       F Bloggs <author@email.com>
 */

/**
 * Class RemoveMe
 * This is example of class documentation description of class
 */
class RemoveMe
{
    
    /**
     * This is example documentation of class method
     *
     * @example
     *
     * <code>
     *
     * $result=RemoveMe::method1();
     *
     * </code>
     *
     * @param int  $arg1
     * @param null $arg2
     *
     * @return int
     */
    public static function method1($arg1 = 0, $arg2 = null)
    {
        return 1;
    }
    
    /**
     * This is example documentation of class method2
     *
     * @example
     *
     * <code>
     *
     * $result=RemoveMe::method2();
     *
     * </code>
     *
     * @return int
     */
    public static function method2()
    {
        return 2;
    }
    
}

/**
 * This is example of trait description
 */
trait RemoveMeTrait
{
    
    /**
     * This is example of interface method description
     *
     * @var string
     */
    public static $name = 'removeMeName';
}

/**
 * This is example of interface description
 */
interface RemovableMe
{
    
    /**
     * This is example of interface method description
     *
     * @return mixed
     */
    public function getRemoveInfoFromME();
}