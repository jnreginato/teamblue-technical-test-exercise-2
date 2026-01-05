<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Integration test for validating the behavior of the PostValidator class in handling
 * and processing input data from POST requests for various scenarios.
 *
 * This test class ensures that:
 * - Valid POST data can be successfully parsed and used to perform operations such as
 *   multiplication or factorial calculations.
 * - Invalid POST data throws appropriate exceptions, ensuring the system fails fast with
 *   incorrect input.
 *
 * Methods test the following functionality:
 * - Parsing and multiplying numbers from valid POST data.
 * - Parsing and calculating factorials from valid POST data.
 * - Handling invalid POST data by throwing domain-specific exceptions.
 */
final class PostValidatorIntegrationTest extends TestCase
{
    /**
     * Scenario: Multiplying two numbers from valid POST data.
     *
     * Given valid POST data containing two numbers,
     * When the method is called with the two numbers,
     * Then the product should be returned.
     */
    public function testCreatesAndMultipliesNumbersFromValidPostData(): void
    {
        // Given (simulating $_POST)
        $postData = [
            'a' => '15',
            'b' => '12',
        ];

        // When
        $a = DigitArrayInteger::fromString(PostValidator::string($postData, 'a'));
        $b = DigitArrayInteger::fromString(PostValidator::string($postData, 'b'));

        $result = $a->multiply($b);

        // Then
        self::assertSame('180', $result->toString());
    }

    /**
     * Scenario: Calculating the factorial of a number from valid POST data.
     *
     * Given valid POST data containing a number,
     * When the method is called with the number,
     * Then the factorial should be returned.
     */
    public function testCreatesAndCalculatesFactorialFromValidPostData(): void
    {
        // Given
        $postData = [
            'n' => '5',
        ];

        // When
        $n = PostValidator::int($postData, 'n');
        $factorialService = new FactorialService();
        $result = $factorialService->calculate($n);

        // Then
        self::assertSame('120', $result->toString());
    }

    /**
     * Scenario: Throwing an exception when multiplying numbers from invalid POST data.
     *
     * Given invalid POST data containing two numbers,
     * When the method is called with the two numbers,
     * Then an InvalidArgumentException should be thrown indicating that the numbers are invalid.
     */
    public function testFailsFastWhenMultipliesNumbersFromInvalidPostData(): void
    {
        // Given
        $postData = [
            'a' => 'abc',
            'b' => '10',
        ];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        $a = DigitArrayInteger::fromString(PostValidator::string($postData, 'a'));
        $b = DigitArrayInteger::fromString(PostValidator::string($postData, 'b'));

        $a->multiply($b)->toString();
    }

    /**
     * Scenario: Throwing an exception when calculating the factorial of a number from invalid POST data.
     *
     * Given invalid POST data containing a number,
     * When the method is called with the number,
     * Then an InvalidArgumentException should be thrown indicating that the number is invalid.
     */
    public function testFailsFastWhenCalculatesFactorialFromInvalidPostData(): void
    {
        // Given
        $postData = [
            'n' => 'abc',
        ];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        $n = PostValidator::int($postData, 'n');
        $factorialService = new FactorialService();
        $factorialService->calculate($n)->toString();
    }
}
