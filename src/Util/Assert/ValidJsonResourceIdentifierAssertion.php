<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class ValidJsonResourceIdentifierAssertion
{
    public function assert(array $resourceIdentifier): bool
    {
        if (false === Assert::arrayHasRequiredKeys($resourceIdentifier, ['id', 'type'])) {
            throw new AssertException('Resource identifier must have `id` and `type` keys');
        }

        if (false === Assert::arrayHasWhitelistedKeysOnly($resourceIdentifier, ['id', 'type', 'meta'])) {
            throw new AssertException('Resource identifier can have `id`, `type`, and `meta` keys only');
        }

        if (false === is_string($resourceIdentifier['id'])) {
            throw new AssertException('Resource `id` must be string');
        }

        if (false === is_string($resourceIdentifier['type'])) {
            throw new AssertException('Resource `type` must be string');
        }

        // @todo validate meta if exists

        return true;
    }
}
