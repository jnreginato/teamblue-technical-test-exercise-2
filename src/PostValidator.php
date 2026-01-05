<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

use function array_key_exists;
use function is_numeric;
use function is_string;

/**
 * Provides utility methods for validating request input data.
 */
final class PostValidator
{
    /**
     * Retrieves a string value from the given array by the given key.
     *
     * @param array<string, mixed> $data The array to retrieve the value from.
     * @param string $key The key to retrieve the value from the array.
     * @return string The string value associated with the given key.
     * @throws InvalidArgumentException If the value associated with the key is not a string.
     */
    public static function string(array $data, string $key): string
    {
        if (!array_key_exists($key, $data) || !is_string($data[$key])) {
            throw new InvalidArgumentException("Invalid value for $key.");
        }

        return $data[$key];
    }

    /**
     * Retrieves an integer value from the given array by the given key.
     *
     * @param array<string, mixed> $data The array to retrieve the value from.
     * @param string $key The key to retrieve the value from the array.
     * @return int The integer value associated with the given key.
     * @throws InvalidArgumentException If the value associated with the key is not an integer.
     */
    public static function int(array $data, string $key): int
    {
        if (!array_key_exists($key, $data) || !is_numeric($data[$key])) {
            throw new InvalidArgumentException("Invalid value for $key.");
        }

        return (int) $data[$key];
    }
}
