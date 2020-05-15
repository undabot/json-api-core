<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

/**
 * @internal
 */
abstract class ArrayUtil
{
    public static function hasRequiredKeys(array $array, array $requiredKeys): bool
    {
        $missingRequiredKeys = array_diff($requiredKeys, array_keys($array));

        return true === empty($missingRequiredKeys);
    }

    public static function isMap(array $array): bool
    {
        $keys = array_keys($array);

        $nonIntKeys = array_filter($keys, static function ($key) {
            return true === \is_string($key);
        });

        return $keys === $nonIntKeys;
    }
}
