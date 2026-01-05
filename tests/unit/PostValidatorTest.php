<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * This class contains unit tests for the PostValidator class.
 *
 * It verifies the behavior of string and integer validation logic in the PostValidator class
 * by providing various test cases for correct and incorrect usage scenarios.
 *
 * Test cases include:
 * - Returning a valid string value when it exists in the data array.
 * - Throwing an exception when the string key does not exist in the data array.
 * - Throwing an exception when the value for a string key is not a valid string.
 * - Returning a valid integer value when it exists in the data array as an integer or numeric string.
 * - Throwing an exception when the integer key does not exist in the data array.
 * - Throwing an exception when the value for an integer key is not a numeric type.
 */
final class PostValidatorTest extends TestCase
{
    /**
     * Scenario: Returning a valid string value when it exists in the data array.
     *
     * Given a data array containing a string value;
     * When the string method is called with the data array and the string key,
     * Then the string value should be returned.
     */
    public function testReturnsStringWhenValueIsAValidString(): void
    {
        // Given
        $data = [
            'name' => 'Jonatan',
        ];

        // When
        $value = PostValidator::string($data, 'name');

        // Then
        self::assertSame('Jonatan', $value);
    }

    /**
     * Scenario: Throwing an exception when the string key does not exist in the data array.
     *
     * Given a data array without a string value;
     * When the string method is called with the data array and the string key,
     * Then an InvalidArgumentException should be thrown indicating that the key does not exist.
     */
    public function testThrowsWhenStringKeyDoesNotExist(): void
    {
        // Given
        $data = [];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        PostValidator::string($data, 'missing');
    }

    /**
     * Scenario: Throwing an exception when the value for a string key is not a valid string.
     *
     * Given a data array containing a non-string value for the string key;
     * When the string method is called with the data array and the string key,
     * Then an InvalidArgumentException should be thrown indicating that the value is not a string.
     */
    public function testThrowsWhenStringValueIsNotAString(): void
    {
        // Given
        $data = [
            'name' => 123,
        ];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        PostValidator::string($data, 'name');
    }

    /**
     * Scenario: Returning a valid integer value when it exists in the data array as an integer or numeric string.
     *
     * Given a data array containing an integer value;
     * When the int method is called with the data array and the integer key,
     * Then the integer value should be returned.
     */
    public function testReturnsIntWhenValueIsAnInteger(): void
    {
        // Given
        $data = [
            'age' => 42,
        ];

        // When
        $value = PostValidator::int($data, 'age');

        // Then
        self::assertSame(42, $value);
    }

    /**
     * Scenario: Returning a valid integer value when it exists in the data array as an integer or numeric string.
     *
     * Given a data array containing a numeric string value;
     * When the int method is called with the data array and the integer key,
     * Then the integer value should be returned.
     */
    public function testReturnsIntWhenValueIsANumericString(): void
    {
        // Given
        $data = [
            'age' => '10',
        ];

        // When
        $value = PostValidator::int($data, 'age');

        // Then
        self::assertSame(10, $value);
    }

    /**
     * Scenario: Throwing an exception when the integer key does not exist in the data array.
     *
     * Given a data array without an integer value;
     * When the int method is called with the data array and the integer key,
     * Then an InvalidArgumentException should be thrown indicating that the key does not exist.
     */
    public function testThrowsWhenIntKeyDoesNotExist(): void
    {
        // Given
        $data = [];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        PostValidator::int($data, 'missing');
    }

    /**
     * Scenario: Throwing an exception when the value for an integer key is not a numeric type.
     *
     * Given a data array containing a non-numeric value for the integer key;
     * When the int method is called with the data array and the integer key,
     * Then an InvalidArgumentException should be thrown indicating that the value is not numeric.
     */
    public function testThrowsWhenIntValueIsNotNumeric(): void
    {
        // Given
        $data = [
            'age' => 'abc',
        ];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        PostValidator::int($data, 'age');
    }
}
