    
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