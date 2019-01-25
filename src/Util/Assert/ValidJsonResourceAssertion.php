<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

use Undabot\JsonApi\Util\Assert\Exception\AssertException;

class ValidJsonResourceAssertion
{
    /**
     * @throws AssertException
     */
    public function assert(array $resource): bool
    {
        // `type` is only required member, `id` is not required when creating a resource without client-generated ID
        $requiredKeys = ['type'];
        $optionalKeys = ['id', 'links', 'meta', 'attributes', 'relationships'];

        if (false === Assert::arrayHasRequiredKeys($resource, $requiredKeys)) {
            $message = sprintf('Resource must have keys: %s', implode(', ', $requiredKeys));
            throw new AssertException($message);
        }

        $whitelistedKeys = array_merge($requiredKeys, $optionalKeys);
        if (false === Assert::arrayHasWhitelistedKeysOnly($resource, $whitelistedKeys)) {
            $message = sprintf('Resource can only have keys: %s', implode(', ', $whitelistedKeys));
            throw new AssertException($message);
        }

        if (true === array_key_exists('id', $resource) && false === is_string($resource['id'])) {
            throw new AssertException('Resource `id` must be string');
        }

        if (false === is_string($resource['type'])) {
            throw new AssertException('Resource `type` must be string');
        }

        // @todo validate attributes
        // @todo validate relationships
        // @todo valdiate links
        // @todo validate meta

        return true;
    }
}
