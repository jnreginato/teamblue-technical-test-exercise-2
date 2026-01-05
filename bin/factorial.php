#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\FactorialService;

$n = (int) ($argv[1] ?? 100);

$service = new FactorialService();
$result = $service->calculate($n);

echo $n . '! = ' . $result->toString() . PHP_EOL;
