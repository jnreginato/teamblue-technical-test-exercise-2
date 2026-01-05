<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

/**
 * Provides functionality for calculating the factorial of a given integer.
 */
final class FactorialService
{
    /**
     * Calculates the product of all integers from 1 to the given number inclusively using the DigitArrayInteger class.
     *
     * @param int $n The upper limit of the range for which the product is calculated. Must be a positive integer.
     * @return DigitArrayInteger The resulting product encapsulated in a DigitArrayInteger object.
     */
    public function calculate(int $n): DigitArrayInteger
    {
        if ($n < 0) {
            throw new InvalidArgumentException('Factorial is not defined for negative numbers.');
        }

        $result = DigitArrayInteger::one();

        for ($i = 2; $i <= $n; $i++) {
            $result = $result->multiply(DigitArrayInteger::fromInt($i));
        }

        return $result;
    }
}
