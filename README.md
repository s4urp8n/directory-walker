    
# Directory walker

This package helps you walk paths from current directory

```php
<?php
$path=DirectoryWalker::fromCurrent()
                                    ->up(2)
                                    ->up()
                                    ->enter('tests')
                                    ->enter('unit/subunit')
                                    ->enter('sub\sub/unit')
                                    ->get();
?>
```

```

Code Coverage Report:     
  2016-08-11 22:58:15     
                          
 Summary:                 
  Classes: 100.00% (1/1)  
  Methods: 100.00% (6/6)  
  Lines:   100.00% (29/29)

\Zver::DirectoryWalker
  Methods: 100.00% ( 6/ 6)   Lines: 100.00% ( 29/ 29)
```
