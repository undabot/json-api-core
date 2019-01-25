<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

class ArrayHasRequiredKeysAssertion
{
    public function assert(array $array, array $requiredKeys): bool
    {
        $missingRequiredKeys = array_diff($requiredKeys, array_keys($array));

        return true === empty($missingRequiredKeys);
    }
}
