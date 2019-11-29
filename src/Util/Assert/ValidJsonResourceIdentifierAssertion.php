<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util\Assert;

class ValidJsonResourceIdentifierAssertion
{
    public function assert(array $resourceIdentifier): bool
    {
        Assert::keyIsset($resourceIdentifier, 'id', 'Resource identifier must have key `id`');
        Assert::keyIsset($resourceIdentifier, 'type', 'Resource identifier must have key `type`');

        $whitelistedKeys = ['id', 'type', 'meta'];
        Assert::allChoice(
            array_keys($resourceIdentifier),
            $whitelistedKeys,
            'Allowed keys are only ' . implode(', ', $whitelistedKeys)
        );

        Assert::string($resourceIdentifier['id'], 'Resource identifier `id` must be string');
        Assert::string($resourceIdentifier['type'], 'Resource identifier `type` must be string');

        // @todo validate meta if exists

        return true;
    }
}
