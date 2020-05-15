<?php

declare(strict_types=1);

namespace Undabot\JsonApi\Util;

class ValidResourceIdentifierAssertion
{
    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function assert(array $resourceIdentifier): void
    {
        $dataSummary = json_encode($resourceIdentifier);

        JsonApiAssertion::keyIsset(
            $resourceIdentifier,
            'id',
            'Resource identifier must have key `id`. Data: ' . $dataSummary
        );
        JsonApiAssertion::keyIsset(
            $resourceIdentifier,
            'type',
            'Resource identifier must have key `type`. Data: ' . $dataSummary
        );

        $whitelistedKeys = ['id', 'type', 'meta'];
        JsonApiAssertion::allChoice(
            array_keys($resourceIdentifier),
            $whitelistedKeys,
            'Allowed keys are only ' . implode(', ', $whitelistedKeys) . '. Data: ' . $dataSummary
        );

        JsonApiAssertion::string(
            $resourceIdentifier['id'],
            'Resource identifier `id` must be string. Data: ' . $dataSummary
        );
        JsonApiAssertion::string(
            $resourceIdentifier['type'],
            'Resource identifier `type` must be string. Data: ' . $dataSummary
        );

        // @todo validate meta if exists
    }
}
