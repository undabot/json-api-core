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

        Assert::keyIsset($resource, 'type', 'Resource must have key `type`');

        $whitelistedKeys = array_merge($requiredKeys, $optionalKeys);
        Assert::allChoice(
            array_keys($resource),
            $whitelistedKeys,
            sprintf('Resource can only have keys: %s', implode(', ', $whitelistedKeys))
        );

        Assert::nullOrString($resource['id'] ?? null, 'Resource `id` must be string');
        Assert::nullOrString($resource['type'] ?? null, 'Resource `type` must be string');

        // @todo validate attributes
        // @todo validate relationships
        // @todo valdiate links
        // @todo validate meta

        return true;
    }
}
