<?php
//Turn on implicit flush
ob_implicit_flush(true);

error_reporting(E_ALL);
ini_set('display_errors', 1);

//Change shell directory to current
chdir(__DIR__);

include "functions.php";

$readme = <<<'README'
    
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

{{DOC_URL_HERE}}

{{COVERAGE_HERE}}

README;

return [
    'server' => "127.0.0.1:4444",
    'readme' => $readme,
];