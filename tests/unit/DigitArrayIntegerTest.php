<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test class for the DigitArrayInteger.
 *
 * This class contains test cases to ensure that the functionality of the
 * DigitArrayInteger behaves as expected.
 *
 * @SuppressWarnings("PHPMD.TooManyPublicMethods")
 */
final class DigitArrayIntegerTest extends TestCase
{
    /**
     * Scenario: Creating an instance from a valid string.
     *
     * Given a valid string,
     * When the method is called with the string,
     * Then a string representation of the DigitArrayInteger should be returned with the same value.
     */
    public function testCreatesAnInstanceFromAValidString(): void
    {
        // Given
        $value = '123';

        // When
        $number = DigitArrayInteger::fromString($value);

        // Then
        self::assertSame('123', $number->toString());
    }

    /**
     * Scenario: Creating an instance from an invalid string.
     *
     * Given an invalid string,
     * When the method is called with the string,
     * Then an InvalidArgumentException should be thrown indicating that the string is invalid.
     */
    public function testThrowsWhenCreatingFromAnInvalidString(): void
    {
        // Given
        $value = '12a3';

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        DigitArrayInteger::fromString($value);
    }

    /**
     * Scenario: Creating an instance from an integer.
     *
     * Given a valid integer,
     * When the method is called with the integer.
     * Then a string representation of the DigitArrayInteger should be returned with the same value.
     */
    public function testCreatesAnInstanceFromAnInteger(): void
    {
        // Given
        $value = 456;

        // When
        $number = DigitArrayInteger::fromInt($value);

        // Then
        self::assertSame('456', $number->toString());
    }

    /**
     * Scenario: Creating an instance from a valid array.
     *
     * Given a valid array of digits in reverse order,
     * When the method is called with the array,
     * Then a string representation of the DigitArrayInteger should be returned with the same value
     * with digits in a natural human-readable order.
     */
    public function testCreatesAnInstanceFromAValidArray(): void
    {
        // Given (reverse digit order)
        $digits = [3, 2, 1];

        // When
        $number = DigitArrayInteger::fromArray($digits);

        // Then
        self::assertSame('123', $number->toString());
    }

    /**
     * Scenario: Creating an instance from an empty array.
     *
     * Given an empty array,
     * When the method is called with the array,
     * Then an InvalidArgumentException should be thrown indicating that the array is empty.
     */
    public function testThrowsWhenCreatingFromAnEmptyArray(): void
    {
        // Given
        $digits = [];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        DigitArrayInteger::fromArray($digits);
    }

    /**
     * Scenario: Creating an instance from an array containing invalid digits.
     *
     * Given an array containing invalid digits,
     * When the method is called with the array,
     * Then an InvalidArgumentException should be thrown indicating that the array contains invalid digits.
     */
    public function testThrowsWhenArrayContainsInvalidDigits(): void
    {
        // Given
        $digits = [1, 2, 10];

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        DigitArrayInteger::fromArray($digits);
    }

    /**
     * Scenario: Trimming leading zeros when creating from an array.
     *
     * Given an array containing leading zeros;
     * When the method is called with the array,
     * Then the leading zeros should be trimmed from the result.
     */
    public function testTrimsLeadingZerosWhenCreatingFromArray(): void
    {
        // Given
        $digits = [0, 0, 3, 2, 1, 0, 0];

        // When
        $number = DigitArrayInteger::fromArray($digits);

        // Then
        self::assertSame('12300', $number->toString());
    }

    /**
     * Scenario: Creating an instance from a valid JSON string.
     *
     * Given a valid JSON string,
     * When the method is called with the JSON string,
     * Then a string representation of the DigitArrayInteger should be returned with the same value.
     */
    public function testCreatesAnInstanceFromValidJson(): void
    {
        // Given
        $json = '[3,2,1]';

        // When
        $number = DigitArrayInteger::fromJson($json);

        // Then
        self::assertSame('123', $number->toString());
    }

    /**
     * Scenario: Throwing an exception when creating from invalid JSON.
     *
     * Given an invalid JSON string,
     * When the method is called with the JSON string,
     * Then an InvalidArgumentException should be thrown indicating that the JSON is invalid.
     */
    public function testThrowsWhenJsonIsNotAnArray(): void
    {
        // Given
        $json = '{"a":1}';

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        DigitArrayInteger::fromJson($json);
    }

    /**
     * Scenario: Throwing an exception when creating from JSON containing non-integers.
     *
     * Given a JSON array containing non-integers,
     * When the method is called with the JSON string,
     * Then an InvalidArgumentException should be thrown indicating that the JSON contains non-integers.
     */
    public function testThrowsWhenJsonArrayContainsNonIntegers(): void
    {
        // Given
        $json = '[1,"2",3]';

        // Then
        $this->expectException(InvalidArgumentException::class);

        // When
        DigitArrayInteger::fromJson($json);
    }

    /**
     * Scenario: Creating zero and one instances.
     *
     * Given that the DigitArrayInteger class has a method to create instances representing zero and one,
     * When the method is called,
     * Then the method should return an instance representing zero or one, respectively.
     */
    public function testCreatesZeroAndOneInstances(): void
    {
        // Given / When / Then
        self::assertSame('0', DigitArrayInteger::zero()->toString());
        self::assertSame('1', DigitArrayInteger::one()->toString());
    }

    /**
     * Scenario: Adding two numbers without carry.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the sum should be returned without a carry.
     */
    public function testAddsTwoNumbersWithoutCarry(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('12');
        $b = DigitArrayInteger::fromString('23');

        // When
        $sum = $a->add($b);

        // Then
        self::assertSame('35', $sum->toString());
    }

    /**
     * Scenario: Adding two numbers with carry.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the sum should be returned with a carry.
     */
    public function testAddsTwoNumbersWithCarry(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('99');
        $b = DigitArrayInteger::fromString('1');

        // When
        $sum = $a->add($b);

        // Then
        self::assertSame('100', $sum->toString());
    }

    /**
     * Scenario: Multiplying two numbers without carry.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the product should be returned without a carry.
     */
    public function testMultipliesTwoNumbersWithoutCarry(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('12');
        $b = DigitArrayInteger::fromString('2');

        // When
        $result = $a->multiply($b);

        // Then
        self::assertSame('24', $result->toString());
    }

    /**
     * Scenario: Multiplying two numbers with carry and shift.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the product should be returned with a carry and shifted to the left.
     */
    public function testMultipliesTwoNumbersWithCarryAndShift(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('15');
        $b = DigitArrayInteger::fromString('12');

        // When
        $result = $a->multiply($b);

        // Then
        self::assertSame('180', $result->toString());
    }

    /**
     * Scenario: Multiplying a number by zero.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the product should be returned as zero.
     */
    public function testMultipliesByZero(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('999');
        $b = DigitArrayInteger::zero();

        // When
        $result = $a->multiply($b);

        // Then
        self::assertSame('0', $result->toString());
    }

    /**
     * Scenario: Multiplying two numbers with internal zero digits.
     *
     * Given two DigitArrayIntegers,
     * When the method is called with the two numbers,
     * Then the product should be returned with internal zero digits.
     */
    public function testMultipliesNumbersWithInternalZeroDigits(): void
    {
        // Given
        $a = DigitArrayInteger::fromString('101');
        $b = DigitArrayInteger::fromString('10');

        // When
        $result = $a->multiply($b);

        // Then
        self::assertSame('1010', $result->toString());
    }
}
