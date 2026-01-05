<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * A test class for validating the behavior of the FactorialService.
 *
 * Ensures that the FactorialService correctly calculates factorials for
 * various inputs and handles edge cases such as zero, large numbers,
 * and negative inputs appropriately.
 *
 * Methods include tests for:
 * - Factorial of zero.
 * - Factorial of one.
 * - Factorial of small positive integers.
 * - Factorial of large numbers.
 * - Handling of negative numbers with proper exception throwing.
 *
 * Each test ensures that the returned result matches the expected value
 * or that an appropriate exception is raised where necessary.
 */
final class FactorialServiceTest extends TestCase
{
    /**
     * Scenario: Calculating the factorial of zero.
     *
     * Given a FactorialService instance,
     * When the calculate method is called with zero,
     * Then the method should return the factorial of zero, which is 1.
     */
    public function testCalculatesFactorialOfZero(): void
    {
        // Given
        $service = new FactorialService();

        // When
        $result = $service->calculate(0);

        // Then
        self::assertSame('1', $result->toString());
    }

    /**
     * Scenario: Calculating the factorial of one.
     *
     * Given a FactorialService instance,
     * When the calculate method is called with one,
     * Then the method should return the factorial of one, which is 1.
     */
    public function testCalculatesFactorialOfOne(): void
    {
        // Given
        $service = new FactorialService();

        // When
        $result = $service->calculate(1);

        // Then
        self::assertSame('1', $result->toString());
    }

    /**
     * Scenario: Calculating the factorial of a small positive integer.
     *
     * Given a FactorialService instance,
     * When the calculate method is called with a small positive integer,
     * Then the method should return the factorial of that integer.
     */
    public function testCalculatesFactorialOfASmallPositiveInteger(): void
    {
        // Given
        $service = new FactorialService();

        // When
        $result = $service->calculate(5);

        // Then
        // 5! = 120
        self::assertSame('120', $result->toString());
    }

    /**
     * Scenario: Calculating the factorial of a large number.
     *
     * Given a FactorialService instance,
     * When the calculate method is called with a large number,
     * Then the method should return the factorial of that number.
     */
    public function testCalculatesFactorialOfALargerNumber(): void
    {
        // Given
        $service = new FactorialService();

        // When
        $result = $service->calculate(10);

        // Then
        self::assertSame('3628800', $result->toString());
    }

    /**
     * Scenario: Throwing an exception when calculating the factorial of a negative number.
     *
     * Given a FactorialService instance,
     * When the calculate method is called with a negative number,
     * Then an InvalidArgumentException should be thrown,
     * indicating that the factorial is not defined for negative numbers.
     */
    public function testThrowsWhenCalculatingFactorialOfANegativeNumber(): void
    {
        // Given
        $service = new FactorialService();

        // Then
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Factorial is not defined for negative numbers.');

        // When
        $service->calculate(-1);
    }
}
