<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

class ArrayIsMapAssertion
{
    public function assert(array $array): bool
    {
        $keys = array_keys($array);

        $nonIntKeys = array_filter($keys, function ($key) {
            return true === is_string($key);
        });

        return $keys === $nonIntKeys;
    }
}
