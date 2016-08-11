    
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

[Documentation](https://s4urp8n.github.io/directory-walker/index.html)

```

Code Coverage Report:     
  2016-08-11 23:56:03     
                          
 Summary:                 
  Classes: 100.00% (2/2)  
  Methods: 100.00% (8/8)  
  Lines:   100.00% (48/48)

\Zver::DirectoryWalker
  Methods: 100.00% ( 8/ 8)   Lines: 100.00% ( 48/ 48)
```
