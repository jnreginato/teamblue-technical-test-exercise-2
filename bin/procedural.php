#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Adds two arrays of single-digit integers element-wise, handling carries.
 *
 * @param array<int> $a An array of single-digit integers representing the first number.
 * @param array<int> $b An array of single-digit integers representing the second number.
 * @return array<int> An array of single-digit integers representing the sum of $a and $b.
 */
function addNumbers(array $a, array $b): array
{
    $result = [];
    $carry = 0;
    $max = max(count($a), count($b));

    for ($i = 0; $i < $max || $carry > 0; $i++) {
        $digitA = $a[$i] ?? 0;
        $digitB = $b[$i] ?? 0;

        $sum = $digitA + $digitB + $carry;
        $result[] = $sum % 10;
        $carry = intdiv($sum, 10);
    }

    return $result;
}

/**
 * Multiplies two arrays that represent numbers in reverse digit order and returns the resulting array
 * representing the product in the same reverse digit order.
 *
 * @param array<int> $a The first number represented as an array of digits in reverse order.
 * @param array<int> $b The second number represented as an array of digits in reverse order.
 * @return array<int> The resulting product represented as an array of digits in reverse order.
 */
function multiplyArrays(array $a, array $b): array
{
    $result = [0];

    foreach ($b as $position => $digitB) {
        if ($digitB === 0) {
            continue;
        }

        $partial = [0];

        // Sum "a" digitB times
        for ($i = 0; $i < $digitB; $i++) {
            $partial = addNumbers($partial, $a);
        }

        // Decimal shift left by position digits (equivalent to multiplying by 10^position)
        for ($i = 0; $i < $position; $i++) {
            array_unshift($partial, 0);
        }

        $result = addNumbers($result, $partial);
    }

    return $result;
}

/**
 * Converts an array of digits into a human-readable string representation of the number.
 *
 * @param array<int> $number An array of digits representing a number in reverse digit order.
 * @return string The number as a string in standard order followed by a newline.
 */
function printNumber(array $number): string
{
    return implode('', array_reverse($number)) . PHP_EOL;
}

// Example usage
$a = [5, 2]; // 25
$b = [0, 3]; // 30

echo printNumber(multiplyArrays($a, $b)); // 750
