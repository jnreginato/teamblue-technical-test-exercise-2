<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

use function array_fill;
use function array_key_exists;
use function array_map;
use function array_merge;
use function array_pop;
use function array_reverse;
use function array_values;
use function count;
use function end;
use function implode;
use function intdiv;
use function is_array;
use function is_int;
use function json_decode;
use function max;
use function preg_match;
use function str_split;

/**
 * Represents a decimal integer using an array of digits
 * and implements arithmetic operations using addition only.
 */
final readonly class DigitArrayInteger
{
    /**
     * Constructs a new instance with the specified array of digits.
     *
     * @param array<int> $digits An array of digit values to initialize the instance.
     * The digits are stored in reverse order (the least significant first).
     * Example: 123 -> [3,2,1]
     */
    private function __construct(private array $digits)
    {
    }

    /**
     * Creates a new instance from the given string representation of a number.
     *
     * @param string $number A string of digits representing a number. Must contain only numeric characters.
     * @return self A new instance initialized with the digits from the input string, stored in reverse order.
     * @throws InvalidArgumentException If the input string contains non-numeric characters.
     */
    public static function fromString(string $number): self
    {
        if (!preg_match('/^\d+$/', $number)) {
            throw new InvalidArgumentException('Invalid number');
        }

        return new self(array_reverse(array_map('intval', str_split($number))));
    }

    /**
     * Creates an instance from an integer representation.
     *
     * @param int $number The integer to convert into an instance.
     * @return self The created instance.
     */
    public static function fromInt(int $number): self
    {
        return self::fromString((string) $number);
    }

    /**
     * Creates a new instance from the given array of digits.
     *
     * @param array<int> $digits An array of digit values to initialize the instance.
     * @return self A new instance initialized with the digits from the input array, stored in reverse order.
     * @throws InvalidArgumentException If the input array contains invalid values or is empty.
     */
    public static function fromArray(array $digits): self
    {
        self::assertNotEmpty($digits);
        self::assertValidDigits($digits);

        $digits = self::trimLeadingZeros($digits);

        return new self($digits);
    }

    /**
     * Creates a new instance from the given JSON-encoded string.
     *
     * @param string $json A JSON-encoded string representing an array of digits.
     * @return self A new instance initialized with the digits from the input array, stored in reverse order.
     * @throws InvalidArgumentException If the input string is not a valid JSON array.
     */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        if (!is_array($data) || !array_key_exists(0, $data)) {
            throw new InvalidArgumentException('Invalid JSON array.');
        }

        $digits = [];

        foreach ($data as $value) {
            if (!is_int($value)) {
                throw new InvalidArgumentException('JSON array must contain only integers.');
            }

            $digits[] = $value;
        }

        return self::fromArray($digits);
    }

    /**
     * Creates an instance initialized to zero.
     *
     * @return self The created instance representing zero.
     */
    public static function zero(): self
    {
        return new self([0]);
    }

    /**
     * Creates an instance pre-initialized with the value of one.
     *
     * @return self The created instance.
     */
    public static function one(): self
    {
        return new self([1]);
    }

    /**
     * Adds the current instance to another instance.
     *
     * @param self $other The instance to add to the current one.
     * @return self A new instance representing the sum of both instances.
     */
    public function add(self $other): self
    {
        $result = [];
        $carry = 0;
        $max = max(count($this->digits), count($other->digits));

        for ($i = 0; $i < $max || $carry > 0; $i++) {
            $digitA = $this->digits[$i] ?? 0;
            $digitB = $other->digits[$i] ?? 0;

            $sum = $digitA + $digitB + $carry;
            $result[] = $sum % 10;
            $carry = intdiv($sum, 10);
        }

        return new self($result);
    }

    /**
     * Multiplies the current instance by another instance.
     *
     * @param self $other The instance to multiply with the current instance.
     * @return self A new instance representing the result of the multiplication.
     */
    public function multiply(self $other): self
    {
        $result = self::zero();

        foreach ($other->digits as $position => $digitB) {
            if ($digitB === 0) {
                continue;
            }

            $partial = self::zero();

            // Sum "a" digitB times
            for ($i = 0; $i < $digitB; $i++) {
                $partial = $partial->add($this);
            }

            // Decimal shift left by position digits (equivalent to multiplying by 10^position)
            $partial = $partial->shift($position);
            $result = $result->add($partial);
        }

        return $result;
    }

    /**
     * Converts the current instance to its string representation.
     *
     * @return string The string representation of the instance.
     */
    public function toString(): string
    {
        return implode('', array_reverse($this->digits));
    }

    /**
     * Shifts the digits by the specified number of positions, filling with zeros.
     *
     * @param int $positions The number of positions to shift the digits. Must be non-negative.
     * @return self A new instance with the shifted digits.
     */
    private function shift(int $positions): self
    {
        if ($positions === 0) {
            return $this;
        }

        return new self(array_merge(
            array_fill(0, $positions, 0),
            $this->digits,
        ));
    }

    /**
     * Ensures that the provided array is not empty.
     *
     * @param array<int> $digits The array to validate.
     * @throws InvalidArgumentException If the array is empty.
     */
    private static function assertNotEmpty(array $digits): void
    {
        if ($digits === []) {
            throw new InvalidArgumentException('Digit array cannot be empty.');
        }
    }

    /**
     * Ensures that the provided array contains only valid digit values.
     *
     * @param array<int> $digits The array to validate.
     * @throws InvalidArgumentException If the array contains invalid values.
     */
    private static function assertValidDigits(array $digits): void
    {
        foreach ($digits as $digit) {
            if ($digit < 0 || $digit > 9) {
                throw new InvalidArgumentException('Digit array must contain only integers between 0 and 9.');
            }
        }
    }

    /**
     * Normalize zeros to the left (at the end of the reversed array).
     *
     * @param array<int> $digits The array to normalize.
     * @return array<int> The normalized array.
     */
    private static function trimLeadingZeros(array $digits): array
    {
        while (count($digits) > 1 && end($digits) === 0) {
            array_pop($digits);
        }

        return array_values($digits);
    }
}
