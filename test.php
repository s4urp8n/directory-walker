<?php
ob_implicit_flush(true);
ini_set('implicit_flush', 1);

echo passthru('.\vendor\bin\phpunit --bootstrap="tests/bootstrap.php"');