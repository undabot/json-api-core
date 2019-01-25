<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

class ArrayHasOnlyWhitelistedKeysAssertion
{
    public function assert(array $array, array $whitelistedKeys): bool
    {
        $extraKeys = array_diff(array_keys($array), $whitelistedKeys);

        return true === empty($extraKeys);
    }
}
