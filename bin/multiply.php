#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\DigitArrayInteger;

if ($argc < 3) {
    echo "Usage: php multiply.php \"[a1]\" \"[a2]\"\n";
    echo "Example: php multiply.php \"[5,1]\" \"[2]\"\n -> 15 * 2\n";
    exit(1);
}

$a = DigitArrayInteger::fromJson($argv[1]);
$b = DigitArrayInteger::fromJson($argv[2]);

$result = $a->multiply($b);

echo $a->toString() . ' * ' . $b->toString() . ' = ' . $result->toString() . PHP_EOL;
