    
# Directory walker

This package helps you walk paths from current directory

### Example of usage:

curent dir is **/project**

```php
<?php
$path=DirectoryWalker::fromCurRErent()
                     ->enter('tests')          //  /project/tests/
                     ->enter('unit/subunit\\') //  /project/tests/unit/subunit/
                     ->up()                    //  /project/tests/unit/
                     ->enter('sub\sub/unit/')  //  /project/tests/unit/sub/sub/unit/
                     ->up(2)                   //  /project/tests/unit/sub/
                     ->upUntil('tests')        //  /project/tests/
                     ->get();
?>
```