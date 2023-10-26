<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

/**
 * @internal
 */
abstract class ArrayUtil
{
    /**
     * @param array<string,mixed> $array
     * @param array<int,string>   $requiredKeys
     *
     * @psalm-suppress PossiblyUnusedMethod
     */
    public static function hasRequiredKeys(array $array, array $requiredKeys): bool
    {
        $missingRequiredKeys = array_diff($requiredKeys, array_keys($array));

        return true === empty($missingRequiredKeys);
    }

    /**
     * @param array<int|string,array<string,string>|string> $array
     *
     * @psalm-suppress DocblockTypeContradiction
     */
    public static function isMap(array $array): bool
    {
        $keys = array_keys($array);

        $nonIntKeys = array_filter($keys, static function ($key) {
            return true === \is_string($key);
        });

        return $keys === $nonIntKeys;
    }

    /**
     * Asserts and returns an array with string keys. If the key does not exist in the source array,
     * it returns an empty array or a specified default value.
     *
     * @param array<mixed> $source The source array from which to extract the value.
     * @param string $key The key to look for in the source array.
     * @param mixed $default The default value to return if the key is not found. Defaults to an empty array.
     * @return array<string, mixed> The asserted array with string keys and mixed values.
     */
    public static function assertStringKeyArray(array $source, string $key, $default = []): array
    {
        $array = $source[$key] ?? $default;

        if (!is_array($array)) {
            throw new \InvalidArgumentException("The value for '{$key}' is not an array.");
        }

        foreach (array_keys($array) as $key) {
            if (!is_string($key)) {
                throw new \InvalidArgumentException("Array key must be a string.");
            }
        }

        return $array;
    }

    /**
     * Asserts and returns a nested array with string keys. If the key does not exist in the source array,
     * it returns an empty array or a specified default value.
     *
     * @param array<mixed> $source The source array from which to extract the value.
     * @param string $key The key to look for in the source array.
     * @param mixed $default The default value to return if the key is not found. Defaults to an empty array.
     * @return array<string, array<string, mixed>> The asserted nested array with string keys at both levels.
     */
    public static function assertStringKeyArrayNested(array $source, string $key, $default = []): array
    {
        $array = $source[$key] ?? $default;

        if (!is_array($array)) {
            throw new \InvalidArgumentException("The value for '{$key}' is not an array.");
        }

        foreach ($array as $topKey => $nestedArray) {
            if (!is_string($topKey)) {
                throw new \InvalidArgumentException("Top-level key must be a string.");
            }

            if (!is_array($nestedArray)) {
                throw new \InvalidArgumentException("Value under '{$topKey}' must be an array.");
            }

            $array[$topKey] = ArrayUtil::assertStringKeyArray($nestedArray, $key);
        }

        return $array;
    }
}
